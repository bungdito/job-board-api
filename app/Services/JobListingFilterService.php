<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class JobListingFilterService
{
    public function applyAdvancedFilters(Builder $query, string $filterString): Builder
    {
        if (empty($filterString)) {
            return $query;
        }

        try {
            $conditions = $this->parseFilterString($filterString);
            return $this->applyConditions($query, $conditions);
        } catch (\Exception $e) {
            Log::error('Error parsing filters: ' . $e->getMessage());
            throw new \InvalidArgumentException('Invalid filter format');
        }
    }

    /**
     * Parses the filter string into a structured condition array.
     * Supports logical operators (AND/OR), relationship filters, and EAV attributes.
     */
    private function parseFilterString(string $filterString): array
    {
        $conditions = [];

        // Handling logical operators and nested conditions
        preg_match_all('/\((.*?)\)/', $filterString, $matches);
        foreach ($matches[1] as $group) {
            $conditions[] = [
                'type' => 'group',
                'logic' => strpos($group, ' OR ') !== false ? 'OR' : 'AND',
                'conditions' => $this->parseBasicConditions($group)
            ];
        }

        return $conditions;
    }

    /**
     * Parses basic conditions without nesting.
     */
    private function parseBasicConditions(string $conditionString): array
    {
        $conditions = [];
        $pattern = '/(\w+)([=<>!]+)([\w-]+)/';
        preg_match_all($pattern, $conditionString, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            if (stripos($match[2], 'IN') !== false) {
                $conditions[] = [
                    'field' => $match[1],
                    'operator' => 'IN',
                    'value' => explode(',', trim($match[3], '()')),
                    'type' => 'basic'
                ];
            } else {
                $conditions[] = [
                    'field' => $match[1],
                    'operator' => $match[2],
                    'value' => $match[3],
                    'type' => 'basic'
                ];
            }
        }
        return $conditions;
    }

    /**
     * Applies the parsed filter conditions to the query.
     */
    private function applyConditions(Builder $query, array $conditions): Builder
    {
        foreach ($conditions as $condition) {
            if ($condition['type'] === 'group') {
                $query->where(function ($q) use ($condition) {
                    foreach ($condition['conditions'] as $index => $subCondition) {
                        if ($index === 0) {
                            $q->where($subCondition['field'], $subCondition['operator'], $subCondition['value']);
                        } else {
                            if ($condition['logic'] === 'AND') {
                                $q->where($subCondition['field'], $subCondition['operator'], $subCondition['value']);
                            } else {
                                $q->orWhere($subCondition['field'], $subCondition['operator'], $subCondition['value']);
                            }
                        }
                    }
                });
            }

            if ($condition['type'] === 'basic') {
                $query->where($condition['field'], $condition['operator'], $condition['value']);
            }

            if ($condition['type'] === 'relationship') {
                $query->whereHas($condition['relation'], function ($q) use ($condition) {
                    $q->whereIn('name', $condition['values']);
                });
            }
        }

        return $query;
    }
}
