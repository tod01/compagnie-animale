<?php

namespace JeroenZwart\CsvSeeder;

use Validator;
use Hash;

class CsvRowParser
{
    private $header;
    private $empty        = FALSE;
    private $defaults     = [];
    private $timestamps   = TRUE;
    private $hashable     = ['password'];
    private $validate     = [];
    private $encode       = TRUE;

    private $key;
    private $value;
    private $row;
    private $parsedRow;

    /**
     * Set the header and possible options to add or parse a row
     *
     * @param array $header
     * @param boolean $empty
     * @param array $defaults
     * @param string $timestamps
     * @param array $hashable
     * @param array $validate
     * @param boolean $encode
     */
    public function __construct( $header, $empty, $defaults, $timestamps, $hashable, $validate, $encode )
    {
        $this->header = $header;

        $this->empty = $empty === NULL ? $this->empty : $empty;

        $this->defaults = $defaults === NULL ? $this->defaults : $defaults;

        $this->timestamps = $timestamps === NULL ? $this->timestamps : $timestamps;

        $this->hashable = $hashable === NULL ? $this->hashable : $hashable;

        $this->validate = $validate === NULL ? $this->validate : $validate;

        $this->encode = $encode === NULL ? $this->encode : $encode;
    }

    /**
     * Parse a CSV row to a database row
     *
     * @param array $row
     * @return array Returns the parsed row
     */
    public function parseRow( $row )
    {
        $this->row = $row;

        $this->mergeRowAndHeader();

        if( empty($this->header) or empty($this->row) ) return FALSE;

        $this->init();

        if( ! $this->doValidate() ) return FALSE;

        foreach( $this->row as $this->key => $this->value )
        {
            $this->isEmptyValue();

            $this->doEncode();

            $this->doHashable();

            $this->parsedRow[ $this->key ] = $this->value;
        }

        $this->addDefaults();

        $this->addTimestamps();

        return $this->parsedRow;
    }

    /**
     * Merge/replace row keys and header values
     *
     * @return void
     */
    private function mergeRowAndHeader( )
    {
        foreach( $this->header as $key => $value )
        {
            $merged[ $this->header[$key] ] = $this->row[$key];
        }

        if( isset($merged) ) $this->row = $merged;
    }

    /**
     * Clear the parsed row
     *
     * @return void
     */
    private function init()
    {
        $this->parsedRow = [];
    }

    /**
     * Validate the row
     *
     * @return void
     */
    private function doValidate()
    {
        if( empty($this->validate) ) return TRUE;

        $validator = Validator::make($this->row, $this->validate);

        if( $validator->fails() ) return FALSE;

        return TRUE;
    }

    /**
     * Set the string value of a boolean to real boolean
     *
     * @return void
     */
    private function isEmptyValue()
    {
        if( $this->empty === FALSE and empty($this->value) ) $this->value = NULL;

        if( strtoupper($this->value) == 'NULL' ) $this->value = NULL;

        if( strtoupper($this->value) == 'FALSE' ) $this->value = FALSE;

        if( strtoupper($this->value) == 'TRUE' ) $this->value = TRUE;
    }

    /**
     * Encode the value to UTF8
     *
     * @return void
     */
    private function doEncode()
    {
        if( $this->encode === FALSE ) return;

        if( is_string($this->value) ) $this->value = mb_convert_encoding( $this->value , 'UTF-8', 'auto');
    }

    /**
     * Hash the value of given column(s), default: password
     *
     * @return void
     */
    private function doHashable()
    {
        if( empty($this->hashable) ) return;

        if( ! in_array($this->key, $this->hashable) ) return;

        $this->value = Hash::make( $this->value );
    }

    /**
     * Add a default column with value to parsed row
     *
     * @return void
     */
    private function addDefaults()
    {
        if( empty($this->defaults) ) return;

        foreach( $this->defaults as $key => $value )
        {
            if( empty($this->parsedRow[ $key ]) ) {
                $this->parsedRow[ $key ] = $value;
            }
        }
    }

    /**
     * Add timestamp to the parsed row
     *
     * @return void
     */
    private function addTimestamps()
    {
        if( empty($this->timestamps) ) return;

        if( $this->timestamps === TRUE ) $this->timestamps = date('Y-m-d H:i:s');

        $this->parsedRow[ 'created_at' ] = $this->timestamps;
        $this->parsedRow[ 'updated_at' ] = $this->timestamps;
    }

}
