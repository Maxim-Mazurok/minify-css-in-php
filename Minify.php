<?php

/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 3/23/17
 * Time: 7:28 PM
 */
class Minify {

    public function run($path) {
        $path = trim($path);
        if ($this->is_valid_path($path)) {
            $text = file_get_contents($path);
            $text = $this->remove_comments($text);
            $text = $this->remove_line_breaks($text);
            $text = $this->remove_repeating_whitespaces($text);
            $text = $this->double_quotes_to_single($text);
            // TODO: needs improvement. see example.css for details.
            //$text = $this->remove_optional_whitespaces($text);
            echo $text;
            $text = $this->remove_optional_semicolons($text);
            $this->write($path, $text);
            return $text;
        } else {
            return 'ERROR: invalid path';
        }
    }

    private function write($original_path, $text) {
        $path = pathinfo($original_path)['dirname'] . '/' .  pathinfo($original_path)['filename'] . '.my.css';
        file_put_contents($path, $text);
    }

    private function remove_optional_semicolons($text) {
        // matches strings with spaces, i.e. 'Open Sans'
        return preg_replace('/;\s*?}/', '}', $text);
    }

    /*private function remove_optional_whitespaces($text) {
        // matches strings with spaces, i.e. 'Open Sans'
        $text = preg_replace('/(\'[^\']*)(\s)([^\']*\')/', '$1___SPACE_PRESERVED_TOKEN___$3', $text);
        // matches all spaces
        $text = preg_replace('/\s+/', '', $text);
        // converts 'Open___SPACE_PRESERVED_TOKEN___Sans' back to 'Open Sans'
        $text = preg_replace('/___SPACE_PRESERVED_TOKEN___/', ' ', $text);
        return $text;
    }*/

    private function double_quotes_to_single($text) {
        // matches 2 or more repeating whitespaces
        return preg_replace('/"/', '\'', $text);
    }

    private function remove_repeating_whitespaces($text) {
        // matches 2 or more repeating whitespaces
        return preg_replace('/\s{2,}/', ' ', $text);
    }

    private function remove_line_breaks($text) {
        // matches UNIX newline character
        return preg_replace('/\n/', '', $text);
    }

    private function remove_comments($text) {
        // matches /*[any unicode character]*/
        return preg_replace('/\/\*\X*?\*\//', '', $text);
    }

    private function is_valid_path($path) {
        if ($path[0] === '/' && in_array(pathinfo($path)['extension'], ['css'])) {
            return true;
        } else {
            return false;
        }
    }
}