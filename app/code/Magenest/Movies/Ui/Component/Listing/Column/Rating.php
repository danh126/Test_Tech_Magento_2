<?php

namespace Magenest\Movies\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class Rating extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $rating = (float) $item['rating'];
                $maxRating = 10;
                $maxStars = 5;

                $starScore = ($rating / $maxRating) * $maxStars;

                $html = '<div style="color: gold; font-size: 16px;">';
                for ($i = 1; $i <= $maxStars; $i++) {
                    if ($starScore >= $i) {
                        $html .= '★';
                    } elseif ($starScore > $i - 1) {
                        $html .= '✬';
                    } else {
                        $html .= '☆';
                    }
                }
                $html .= '</div>';
                $item['rating'] = $html;
            }
        }

        return $dataSource;
    }
}
