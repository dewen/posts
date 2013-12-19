<?php

class CSVFormatter implements iFormattable
{
    /**
     * format array into CSV
     *
     * NOTES: 
     *  logic copied from 
     *  http://stackoverflow.com/questions/3933668/convert-array-into-csv
     *
     * @param   $fields       array
     *
     * @return  csv formatted string
     */
    public function format($fields, $delimiter = ',', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false)
    {
        $delimiter_esc = preg_quote($delimiter, '/');
        $enclosure_esc = preg_quote($enclosure, '/');

        $output = array();
        foreach((array)$fields as $field) {
            if ($field === null && $nullToMysqlNull) {
                $output[] = 'NULL';
                continue;
            }

            // Enclose fields containing $delimiter, $enclosure or whitespace
            if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
                $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
            }
            else {
                $output[] = $field;
            }
        }

        return implode($delimiter, $output) . PHP_EOL;
    }
}
