<?php

require_once __DIR__ . '/../classes/templateengine.php';

class Comparison {

    public function __construct($locations) {
        $this->locations = $locations;
    }

    public function render() {
        $templateEngine = new TemplateEngine();

        $args = [];
        $args['title'] = 'Weather for ' . $this->locations[0]->name() . ' and ' . $this->locations[1]->name() . ' compared';
        $args['comparisonSentenceHtml'] = $this->comparisonSentenceHtml($this->locations[0], $this->locations[1]);

        $side = 'left';
        foreach ($this->locations as $n => $location) {
            $locationArgs = [
                'side' => $side,
                'name' => $location->name(),
                'icon' => $location->icon(),
                'temperature' => round($location->temperature()),
            ];
            $args["location{$n}Html"] = $templateEngine->render('location', $locationArgs);
            $side = 'right';
        }

        return $templateEngine->render('comparison', $args);
    }

    protected function comparisonSentenceHtml($location1, $location2) {
        $startDate   = Config::startDate();
        $now         = date('Y-m-d');
        $displayDate = date('F jS', strtotime($startDate));
        if ($location1->averageTemperature($startDate, $now) > $location2->averageTemperature($startDate, $now) + 0.1) {
            $warmer = $location1;
            $colder = $location2;
        } elseif ($location1->averageTemperature($startDate, $now) < $location2->averageTemperature($startDate, $now) + 0.1) {
            $warmer = $location2;
            $colder = $location1;
        } else {
            return 'The average temperature has been the <b>same<b> in <b>both places</b> since <b>' . q($displayDate) . '</b>';
        }
        $warmerTemperature = $warmer->averageTemperature($startDate, $now);
        $colderTemperature = $colder->averageTemperature($startDate, $now);
        $difference = round($warmerTemperature - $colderTemperature, 1);
        return 'It has been an average of <b>' . q($difference) . ' degrees warmer</b> in <b>' . q($warmer->name()) . '</b> since <b>' . q($displayDate) . '</b>';
    }
}
