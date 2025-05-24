<?php
namespace Magenest\ColorSwitcher\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;

class ColorRow extends Field
{
    protected function _getElementHtml(AbstractElement $element)
    {
        $elementName = $element->getName();

        $html = '<table id="custom_colors_table" style="border-collapse: collapse;">';
        $html .= '<thead><tr>';
        $html .= '<th style="border:1px solid #ccc; padding:5px;">Color Name</th>';
        $html .= '<th style="border:1px solid #ccc; padding:5px;">Hex Code</th>';
        $html .= '<th style="border:1px solid #ccc; padding:5px;">Preview</th>';
        $html .= '<th style="border:1px solid #ccc; padding:5px;">Action</th>';
        $html .= '</tr></thead>';

        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td style="border:1px solid #ccc; padding:5px;"><input type="text" name="' . $elementName . '[0][name]" /></td>';
        $html .= '<td style="border:1px solid #ccc; padding:5px;"><input type="text" name="' . $elementName . '[0][hex]" oninput="updatePreview(this)" /></td>';
        $html .= '<td style="border:1px solid #ccc; padding:5px;"><div style="width:30px; height:20px; border:1px solid #e12e2e;" class="color-preview"></div></td>';
        $html .= '<td style="border:1px solid #ccc; padding:5px;"><button type="button" onclick="addRow()">+</button></td>';
        $html .= '</tr>';
        $html .= '</tbody>';
        $html .= '</table>';

        $html .= '<script>
            function addRow() {
                const table = document.getElementById("custom_colors_table").getElementsByTagName("tbody")[0];
                const rowCount = table.rows.length;
                const row = table.insertRow();
                row.style.border = "1px solid #ccc";
                row.innerHTML = `
                    <td style="border:1px solid #ccc; padding:5px;">
                        <input type="text" name="' . $elementName . '[${rowCount}][name]" />
                    </td>
                    <td style="border:1px solid #ccc; padding:5px;">
                        <input type="text" name="' . $elementName . '[${rowCount}][hex]" oninput="updatePreview(this)" />
                    </td>
                    <td style="border:1px solid #ccc; padding:5px;">
                        <div style="width:30px; height:20px; border:1px solid #000;" class="color-preview"></div>
                    </td>
                    <td style="border:1px solid #ccc; padding:5px;">
                        <button type="button" onclick="this.parentElement.parentElement.remove()">-</button>
                    </td>
                `;
            }

            function updatePreview(input) {
                const val = input.value.trim();
                const previewDiv = input.parentElement.nextElementSibling.querySelector(".color-preview");
                if(/^#([0-9A-Fa-f]{3}){1,2}$/.test(val)) {
                    previewDiv.style.backgroundColor = val;
                } else {
                    previewDiv.style.backgroundColor = "transparent";
                }
            }
        </script>';

        return $html;
    }
}
