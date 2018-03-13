<?php

namespace Redwine\Database;

class Types
{
    static function columnTypes($request, $table, $i)
    {
        $column = false;

        // length/Values

        if ($request->data[$i]["Length"] != null) {
            if ($request->data[$i]["Length"] > 191 || $request->data[$i]["Length"] < 0) {
                $length = 191;
            } else {
                $length = $request->data[$i]["Length"];
            }
        } else {
            $length = 191;
        }

        // Column Types

        if ($request->data[$i]["Type"] == "int") {
            $column = $table->integer($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "varchar") {
            $column = $table->string($request->data[$i]["Name"], $length);
        }

        if ($request->data[$i]["Type"] == "text") {
            $column = $table->text($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "date") {
            $column = $table->date($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "timestamp") {
            $column = $table->timestamp($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "tinyint") {
            $column = $table->tinyInteger($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "smallint") {
            $column = $table->smallInteger($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "bigint") {
            $column = $table->bigInteger($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "decimal") {
            $column = $table->decimal($request->data[$i]["Name"], 8, 2);
        }

        if ($request->data[$i]["Type"] == "float") {
            $column = $table->float($request->data[$i]["Name"], 8, 2);
        }

        if ($request->data[$i]["Type"] == "double") {
            $column = $table->double($request->data[$i]["Name"], 8, 2);
        }

        if ($request->data[$i]["Type"] == "boolean") {
            $column = $table->boolean($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "datetime") {
            $column = $table->dateTime($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "time") {
            $column = $table->time($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "char") {
            $column = $table->char($request->data[$i]["Name"], $length);
        }

        if ($request->data[$i]["Type"] == "mediumtext") {
            $column = $table->mediumText($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "longtext") {
            $column = $table->longText($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "binary") {
            $column = $table->binary($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "blob") {
            $column = $table->binary($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "geometry") {
            $column = $table->geometry($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "point") {
            $column = $table->point($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "linestring") {
            $column = $table->lineString($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "polygon") {
            $column = $table->polygon($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "multipoint") {
            $column = $table->multiPoint($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "multilinestring") {
            $column = $table->multilinestring($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "multipolygon") {
            $column = $table->multiPolygon($request->data[$i]["Name"]);
        }

        if ($request->data[$i]["Type"] == "geometrycollection") {
            $column = $table->geometryCollection($request->data[$i]["Name"]);
        }

        // Column Modifiers

        if ($request->data[$i]["Unsigned"] == 1) {
            $column->unsigned();
        }

        if ($request->data[$i]["AutoIncrement"] == 1) {
            $column->autoIncrement();
        }

        if ($request->data[$i]["NotNull"] != 1) {
            $column->nullable();
        }

        if ($request->data[$i]["Default"] != null) {
            $column->default($request->data[$i]["Default"]);
        }

        if ($request->data[$i]["AutoIncrement"] == 0) {
            if ($request->data[$i]["Index"] == 1) {
                $table->index($request->data[$i]["Name"]);
            } elseif ($request->data[$i]["Index"] == 2) {
                $table->unique($request->data[$i]["Name"]);
            } elseif ($request->data[$i]["Index"] == 3) {
                $table->primary($request->data[$i]["Name"]);
            }
        }

        return $column;
    }
}
