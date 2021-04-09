<?php

class Rule
{

    private $title;
    private $intensity;
    private $text;

    public function getTitle() {
        return $this->title;
    }

    public function getIntensity() {
        return $this->intensity;
    }

    public function getText() {
        return $this->text;
    }

    // Main Rule Generation Method
    public function generateRule($scale) {
        $this->text = "";
        $rawText = $this->getRule($scale);
        $this->formatRaw($rawText);
        $this->intensity = $scale;
    }

    // Random rule retrieval.
    private function getRule($scale) {

        $rulesMinor = array(
            "[title:Care Package]All players start with [number:2,5] [resources].",
            "[title:Deterrent]The robber starts on the [nice_terrain] tile with the best odds. Devise a fair way to choose if multiple tiles are tied for this title.",
            "[title:Deserted]Place every desert tile available in the middle of the board to form one large desert area."
        );

        $rulesModerate = array(
            "[title:Pickpocketing Prowess]Steal two resources instead of one from a single adjacent player when you move the robber to a new tile.",
            "[title:Roadless]When players build their first two settlements at the start of the game, they do not build any free roads branching off.",
            "[title:Black Market Grains]At any time when a player is allowed to trade, they can exchange [number:4,6] [resources_excluding_grain] for [number:2,5] grain resources.",
            "[title:City Planning]The first time a player builds a city, they draw a development card immediately."
        );

        $rulesMajor = array(
            "[title:Coastal Champion]To win the game, players must have at least one [select_from:settlement,city] adjacent to water.",
            "[title:Harsh Terrain]Cities cannot be built adjacent to [select_from:desert,mountain,goldmine] terrain tiles."
        );

        $index = 0;

        if ($scale == 1) {
            $index = array_rand($rulesMinor);
            return $rulesMinor[$index];
        }
        elseif ($scale == 2) {
            $index = array_rand($rulesModerate);
            return $rulesModerate[$index];
        }
        else {
            $index = array_rand($rulesMajor);
            return $rulesMajor[$index];
        }
    }

    // Format the text so humans like it.
    private function formatRaw($pre) {

        $temp = "";
        $track = false;

        $textChars = str_split($pre);
        foreach ($textChars as $char) {


            if ($char != "[" && $track == false) {
                $this->text = $this->text . $char;
            }

            else {

                if ($char == "[") {
                    $track = true;
                }
                elseif ($char == "]") {
                    $this->handleAction($temp);
                    $temp = "";
                    $track = false;
                }
                else {
                    $temp = $temp . $char;
                }

            }
        }

    }

    // Do special things.
    private function handleAction($action) {

        $new = explode(":", $action);

        if ($new[0] == "title") {
            $this->title = $new[1];
        }
        elseif ($new[0] == "number") {
            $range = explode(",", $new[1]);
            $num = rand($range[0], $range[1]);
            $this->text = $this->text . strval($num);
        }
        elseif ($new[0] == "resources") {
            $options = array("bricks", "lumber", "wool", "grain", "ores");
            $this->text = $this->text . $options[rand(0, 4)];
        }
        elseif ($new[0] == "nice_terrain") {
            $options = array("forest", "pasture", "field", "hills", "mountain", "goldmine" );
            $this->text = $this->text . $options[rand(0, 5)];
        }
        elseif ($new[0] == "resources_excluding_grain") {
            $options = array("bricks", "lumber", "wool", "ores");
            $this->text = $this->text . $options[rand(0, 3)];
        }
        elseif ($new[0] == "select_from") {
            $options = explode(",", $new[1]);
            $selection = array_rand($options);
            $this->text = $this->text . $options[$selection];
        }

    }


}