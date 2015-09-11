# Cyrcho
Converts cyrillic into latin using the correct transliteration rules

Several years ago I converted the original work of ["Loshia"](http://loshia.com/wp/cyrillic-slugs/) into a WordPress plugin called [wp-cyr-cho](https://wordpress.org/plugins/wp-cyr-cho/). Since then on more than a few occasions I need to do the *cyrillic-to-latin* convertion, and each time I copied and pasted the "guts" of the WordPress plugin. I think it is time to create a re-usable standalone library ;)

## Usage
There is only one public static method that does all the work, and it is very easy to use:

	$latin = cyrcho::cyr2latin($cyrilic);


