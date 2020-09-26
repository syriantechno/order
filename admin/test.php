<?php
/**
 * Created by PhpStorm.
 * User: loayalshaeer
 * Date: 2020-09-01
 * Time: 14:12
 */
$sql = "INSERT INTO prodb.simplex_list 
                   code, description, manufacturer, 
                   cost_per_unit, weight_per_unit, bar_code,
                   ingredients_list, allergens_contains,
                   allergens_may_contain) 
                VALUES 
                  ( '$proCode', '$proDescr' , '$proManu', 
                   '$proCPU' , '$proWPU' , '$proBarCode', 
                   '$proIngredients' , '$proAllergens', 
                   '$proMayAllergens')";
$sql = "INSERT INTO prodb.simplex_list 
         (code, description, manufacturer, 
          cost_per_unit, weight_per_unit, 
          bar_code, ingredients_list, allergens_contains, 
          allergens_may_contain) 
         VALUES ('$proCode', '$proDescr', '$proManu',
                 '$proCPU','$proWPU', '$proBarCode', 
                 '$proIngredients', '$proAllergens', 
                 '$proMayAllergens')";