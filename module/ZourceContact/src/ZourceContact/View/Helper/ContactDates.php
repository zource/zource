<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZourceContact\Form\Element\ContactDates as ContactDatesElement;

class ContactDates extends AbstractHelper
{
    public function __invoke(ContactDatesElement $element)
    {
        $result = '<table class="zui-table-list">';
        $result .= '<thead>';
        $result .= '<tr>';
        $result .= '<th>Type</th>';
        $result .= '<th>Date</th>';
        $result .= '<th></th>';
        $result .= '</tr>';
        $result .= '</thead>';
        $result .= '<tbody>';

        for ($i = 0; $i < 5; ++$i) {
            $result .= '<tr>';
            $result .= '<td>';
            $result .= '<select>';
            $result .= '<option value="">Birthday</option>';
            $result .= '<option value="">Deathday</option>';
            $result .= '</select>';
            $result .= '</td>';
            $result .= '<td><input type="text" value="2016-06-08" /></td>';
            $result .= '<td class="zui-text-right">';
            $result .= '<a href="" class="zui-button zui-button-link">Edit</a> - ';
            $result .= '<a href="" class="zui-button zui-button-link">Remove</a>';
            $result .= '</td>';
            $result .= '</tr>';
        }

        $result .= '</tbody>';
        $result .= '</table>';

        return $result . '<p><a href="" class="zui-button">Add</a></p>';
    }
}
