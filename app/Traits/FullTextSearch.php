<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03/09/18
 * Time: 10:36
 */

namespace Memed\Traits;


trait FullTextSearch

{
    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if(strlen($word) >= 1) {
                $words[$key] = '+' . $word . '*';
            }
        }

        $searchTerm = implode( ' ', $words);

        return $searchTerm;
    }

    /**
     * Scope a query that matches a full text search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
//    public function scopeSearch($query, $term)
//    {
//        $columns = implode(',',$this->searchable);
//
//        $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)" , $this->fullTextWildcards($term));
//
//        return $query;
//    }
    public function scopeSearch($query, $term)
    {
        $columns = implode(',',$this->searchable);

        $searchableTerm = $this->fullTextWildcards($term);

        if(!$this->regex($term)) {
            return $query->select('*')
                ->selectRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE) AS relevance_score", [$searchableTerm])
                ->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $searchableTerm)
                ->orderByDesc('relevance_score');
        }
       return $query->select('*')->where('email','like',"%$term%");

    }

    public function regex($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
           return true;
        }
    }
}