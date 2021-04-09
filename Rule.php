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
            "[title:Deterrent]The robber starts on the [nice_terrain] tile with the best odds. Devise a fair way to choose if multiple tiles are tied for this title."
        );

        $rulesModerate = array(
            "[title:Pickpocketing Prowess]Steal two resources instead of one from a single adjacent player when you move the robber to a new tile.",
            "[title:Roadless]When players build their first two settlements at the start of the game, they do not build any free roads branching off."
        );

        $index = 0;

        if ($scale == 1) {
            $index = array_rand($rulesMinor);
            return $rulesMinor[$index];
        }
        else {
            $index = array_rand($rulesModerate);
            return $rulesModerate[$index];
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

    }


}