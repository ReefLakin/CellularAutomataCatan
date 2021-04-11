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

        // 8 Rules
        $rulesMinor = array(
            "[title:Care Package]All players start with [number:2,5] [resources].",
            "[title:Deterrent]The robber starts on the [nice_terrain] tile with the best odds. Devise a fair way to choose if multiple tiles are tied for this title.",
            "[title:Deserted]Place every desert tile available in the middle of the board to form one large desert area.",
            "[title:Pain Medicine]The first player to roll a twelve picks up an instant [resource] resource.",
            "[title:Achievement Get]The feat of [select_from:largest army,longest route] is worth 1 extra Victory Point.",
            "[title:Share The Wealth]The first time a player builds a settlement during game time, all other players receive an immediate [resource] resource.",
            "[title:Helping Hand]All players start the game with a random development card.",
            "[title:Wasteland Wonders]When players build adjacent to a desert tile, they draw [number:1,4] [resource] resources immediately."
        );

        // 9 Rules
        $rulesModerate = array(
            "[title:Pickpocketing Prowess]Steal two resources instead of one from a single adjacent player when you move the robber to a new tile.",
            "[title:Roadless]When players build their first free settlements at the start of the game, they do not build any free roads branching off.",
            "[title:Black Market Grains]At any time when a player is allowed to trade, they can exchange [number:4,6] [resources_excluding_grain] for [number:2,5] grain resources.",
            "[title:City Planning]The first time each player builds a city, they draw a development card immediately.",
            "[title:Docks Sabotage]The two-for-one [resource] port will be destroyed after [select_from:20,30,40,50,60] minutes of game time has elapsed. When destroyed, it is disabled.",
            "[title:All-Seeing]Introducing: the Watchtower. Max one per player. Inherits most properties of settlements. Place the settlement piece on its end face so it's taller than it is wide. It doesn't generate resources. Cannot be upgraded. It costs [number:3,4] [select_from:ore,bricks,lumber] and a [select_from:grain,wool]. The robber cannot be placed on a tile with a Watchtower adjacent.",
            "[title:Outcropping]Place every field tile in one corner of the board to form one large field zone.",
            "[title:Intimidation]Knight cards can be played at any time after someone rolls dice. Their usual function is negated. Instead, the player has to re-roll and nobody gets any resources.",
            "[title:Pick Me Up]At the start of the game, after placing the first settlements, each player rolls a die. They can then pick up that many resources of their choice from the supply, excluding [resources]."
        );

        // 9 Rules
        $rulesMajor = array(
            "[title:Coastal Champion]As an additional win condition, players must have at least one [select_from:settlement,city] adjacent to water.",
            "[title:Harsh Terrain]Cities cannot be built adjacent to [select_from:desert,mountain,goldmine] terrain tiles.",
            "[title:Thievery For Hire]Players can sacrifice the rest of their turn and expend [number:3,6] [resources] to move the robber at the very start of their turn (prior to rolling).",
            "[title:City Life]Usually, players build two free settlements and roads anywhere at the start of the game. Instead, these are replaced with a single city and [number:2,4] roads.",
            "[title:Sinking Feeling]After [select_from:30,45,60] minutes of game time has elapsed, the [nice_terrain] tile with the [select_from:best,worst] odds will fall into the sea. Flip the tile to identify it as sunken. Devise a fair way to choose if multiple tiles are tied for this title.",
            "[title:We Have Spoken]Introducing: the Council Building. Max one per player. Inherits most properties of cities. Place the city piece on its largest face so it's wider than it is tall. Used as an upgrade to a city. It costs [number:2,5] [select_from:bricks,grain,lumber] and [number:1,4] [select_from:ore,wool]. To win the game, a player must have a Council Building.",
            "[title:Sharing Is Caring]Every time a [select_from:2,3,4,10,11,12] is rolled, all players must pass at least one resource to the player on their left (if they have any).",
            "[title:Overpowered]Cities generate three resources each time, instead of two.",
            "[title:Personal Space]Players do not have to abide by the 'distance rule' and can build settlements only one road apart from others."
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
        elseif ($new[0] == "resource") {
            $options = array("brick", "lumber", "wool", "grain", "ore");
            $this->text = $this->text . $options[rand(0, 4)];
        }

    }


}