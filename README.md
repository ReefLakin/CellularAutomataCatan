# Cellular Automata Catan

A landmass generator for Catan Seafarers, using elementary cellular automation.

<br>

---

<br>

## Navigation

<br>

- [About](#About)
    - [Wolfram Rules Examples](#Rule-30)
    - [Rule 153 Example](#Rule-153-In-Action)
- [Contribute](#Contribute)
- [Changelog](#Changelog)
    - [The Mobile Patch](#The-Mobile-Patch)
    - [The Stylish Update](#The-Stylish-Update)
- [FAQs](#FAQs)

<br>

---

<br>

## About

Randomly generating your map with Catan's original board is simple: shuffle the tiles and the little numbered circles, and get to work scattering them across your world with little effort or premeditated design. The resulting tile arrangement should be unique and hopefully provide you with yet another interesting game. Of course, players are welcome to design their maps however they wish. But it is far more interesting to throw them down into a random arrangement that nobody can be prepared for.

**Seafarers**, Catan's first official expansion (not to be confused with the "extension") broadened the boundries of Catan's world and added oceans, among other things. Now, generating the landmass pre-game was less straight-forward. There were islands to be scattered about amidst the sea tiles and just shuffling all the tiles together wasn't going to really cut it. Of course you could still do this, but it got me thinking, *is there a better way?"*

Enter stage left: cellular automation. The concept is the original brainchild of Stanislaw Ulam and John von Neumann, but it was British mathematician John Conway's Game of Life that really perpetuated intrigue into the field. For this project, I am using 1-dimensional elementary cellular automation, something which has been heavily studied by Stephen Wolfram, to generate Catan landmasses amongst ocean tiles that I believe offers the optimal ratio of randomness to uniformity.

Let me try and explain. One need only follow a simple ruleset to generate their map of Catan. Each cell is a product of its neighbours, specifically the three cells above it. And each cell has a single binary state: dead or alive. Therefore, there are eight binary combinations to consider when classifying a cell's state. This is because three binary units can be switched on and off in eight unqiue ways. But eight is the limit. Wolfram's rules, leaves us with 256 combinations total. Still following? Don't worry if you're not, there's a handy image coming up. These 256 combinations can fit nicely into an 8-bit number, decimal 255 (or binary 11111111). Thus, we now have 255 different cellular automation rules to apply to our map of Catan. Here are three examples if the above word vomit hasn't really had a chance to settle in yet:

<br>

### Rule 30
30 is 00011110 in binary. You can see this has been reflected in the ruleset below.

![A diagram of Wolfram's Rule 30](http://atlas.wolfram.com/01/01/30/01_01_108_30.gif)

### Rule 60
In binary, 60 is 00111100.

![A diagram of Wolfram's Rule 60](http://atlas.wolfram.com/01/01/60/01_01_108_60.gif)

### Rule 153
In binary, 153 is 10011001. Take note, we'll be using this one later.

![A diagram of Wolfram's Rule 153](http://atlas.wolfram.com/01/01/153/01_01_108_153.gif)

<br>

Those images were taken in good faith from The Wolfram Atlas. Find out more here: *http://atlas.wolfram.com/*.

Lets see how it works with Catan. Firstly, we select a rule. For the sake of visuals, we'll use Rule 153. See the above image for the ruleset. And now for the starting cells (i.e. which cells are going to start active and which ones disabled on the top row so we can start generating some interesting patterns?). So that both numbers the user enters can have the same floor and ceiling, I made the design decision to add an extra column to my Catan map board. This is because, usually, a map only has a width of 7 tiles and I wanted to work with 8 bits all over. You can still make some bangin' maps without the extra column, but I wanted it and so here we are. For our example, 126 will be our starting value. This is 01111110 in binary. Our first row, therefore will have two cells dead (the end ones) and the six middle cells alive.

To generate your map, traverse the board from top to bottom applying Rule 153 to every single cell. This is pretty weird when you're doing it to an uneven hexagon board. Just keep in mind each cell's above neighbours are the cells directly adjacent to its top left, top middle and top right fringes. A Catan board also doesn't have even rows. The uppermost one, for instance, has only a single hexagon. Therefore, I have added imaginary hexagons that span the entire row, making our board 8x8 when, in reality, it is far from this. The mystical eigth column I appended to the right side of my board is also imaginary, and used purely for added pattern-generation purposes.

Below, you can see how the combination of my starting value (binary 126) and selected ruleset (153) send a cacading pattern of land and sea tiles nicely down my board in what I consider to be an immensely satisfying display of elementary cellular automation at work. I use wrap-around so the endmost tiles have something to reference. This is basically like Pac-Man running off the screen to the left and appearing immediately on the right.

<br>

### Rule 153 in Action
We use a starting series of hexes and Rule 153 to achieve the following pattern.

![A short animation of a Catan board being generated.](https://i.imgur.com/47M6pph.gif)

<br>

There we have it. Blue tiles represent water and green tiles represent land. The greyed out hexagons are for generation purposes only and aren't needed when setting up the board in the real world. My friends and I call this bad boy THE SHURIKEN, because the water tiles connect to form the shape of a ninja throwing star. Pretty neat I'm sure you'll agree.

You can spend fifteen minutes sketching the hexagons and colouring them in like the animation above, but why would you do that when you can have a helpful website do it for you? Furthermore, there is no guarantee the map you generate will be any good. With over 65,000 combinations of maps to generate, trust me when I say there are some less-than-decent ones out there. It should also be noted that you may get more water tiles generate than land. In this case, just swap which colour represents land and which represents water and you'll be laughing.

<br>

---

<br>

## Contribute

The most straight forward way to change something about the website is to request it. You can do so by reaching out to me at *reeflakin2@gmail.com*. I will try to respond as early as possible. I welcome suggestions about ways to improve the site, of course, but any other inquiry is acceptable.

Failing this, take matters into your own hands by forking the repo and mucking about yourself.

<br>

---

<br>

## Changelog

Not all updates are shown here, only the most recent ones.

### The Mobile Patch

#### Planned:

- Provide more useful information to accompany the forms.
- Form boxes remain filled when "Submit" button is pressed.

#### Features:

- Reworked the hex grid so it is easier to manipulate and looks better on mobile.

#### Changes:

- Moved the old website to a new navigation tab named "Deprecated Generator".

#### Documentation:

- Restyled some of the README.
- Added more attribution.

<br>

### The Stylish Update

Implemented **27/03/2021**. Previously, my site was a akin to a barren desert, void of colour and sex appeal. Now, we have a splash of style and it's looking pretty nice. Enjoy!

#### Features:

- Added a navigation bar in preparation for a multi-page site.
- Added form styling.
- Added "Randomize" button.
- Added more styling to map section.
- Added site logo.
- Added footer.

#### Documentation:

- Added a "Changelog" section.
- Added a "Contribute" section, with details on how one may contribute to the site.
- Added a "Special Thanks" section, appreciating the resources deserving of recognition.
- Added 2 new FAQs.

<br>

---

<br>

## FAQs

If you have a question that is yet to be answered, reach out to me at *reeflakin2@gmail.com* and I will add it below.

<br>

> ### The central tile at both the bottom and top can be generated on your site, but these hexes are attached to the border piece and are literally always water. What gives?

This refers to the middle hexagon at both the base and top of the board. In fact, whilst hexagon shapes, these are actually just extension of the border pieces that come with the base game and, unfortunately, are always water. However, this does not prevent players from placing land tiles over this water to match what is generated.

<br>

> ### Why did you include that imaginary column of hexagons to the right of the main board?

This was a design choice. Only later in development did I realise I probably could have done without it, but it stuck with me and I continued using it for the rest of the project.

<br>

> ### Will you add a dark mode?

Unpopular opinion: dark mode is overrated. But I'd consider it if there was a demand.

<br>

> ### What are the best Rules to use for this?

Consider some of my personal favourites: 25, 60, 61, 73, 101, 105 and 153; they make some pretty sweet maps!

<br>

---

<br>

## Special Thanks

### Vincent Martin

> https://github.com/vmcreative/Hexi-Flexi-Grid

I ripped all the hexagon code from one of Vincent's GitHub repositories, that has been aptly titled Hexi-Flexi Grid. Great work!

### Bootstrap

> https://getbootstrap.com/

Classic, I'm sure you'll agree. Check them out in the link above.

### Thomas Park

> https://github.com/thomaspark/bootswatch

Big thanks to Thomas and the 70+ other contributers for making Bootswatch this guy's go-to for sexy styling.

### Betheny Waygood

> https://www.instagram.com/bwaygood_art/

Betheny Waygood is the gal behind the site's logo. Check her out on Instagram in the link above. She does loads of great art; give her some love!

### MattH22

> https://codepen.io/MattH22/pen/pqFLJ

The previous hexagon grid was stolen from the legend that is Matt. You can check out his code in the link above!