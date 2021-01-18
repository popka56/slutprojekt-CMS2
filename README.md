Ett tema och plugins för wordpress projekt som använder woocommerce.

# Installation:
Dra "theme" och "plugins" mapparna från detta projekt in till din egna wordpress-installations wp-content mapp.
Destinationen bör se ut så här: 
"...din-wordpress-installation/wp-content"

# Temat
...

# Plugins
Projektet kommer med fyra plugins: "betalnings-plugin", "shippingplugin", "leverans-plugin-2" och "test-plugin".

## betalnings-plugin
Ett plugin som lägger till betalning via faktura från giltigt personnummer. Kunder som väljer att betala med denna metod måste ange giltigt personnummer i kassan för att ordern ska gå igenom.

När pluginet är aktiverat kan betalningsmetoden aktiveras för kunder genom att gå in i Woocommerces inställningar, under "Payments". Aktivera metoden "Faktura" och den bör dyka upp under kassan för kunderna. Du kan även ändra dess titel och beskrivning som syns i kassan genom att klicka på betalningsmetoden och ändra textfälten som då visas upp.

## shippingplugin
...

## leverans-plugin-2
Ännu ett plugin som lägger till en ny leverensmetod, denna gången för att hämta i butik. Kunder som väljer denna leveransmetod får välja mellan butikerna som skapats under temats "Butiker" flik.

När pluginet är aktiverat kan leveransmetoden aktiveras för kunder genom att gå in i Woocommerces inställningar, under "Shipping". Här kan även ett pris sättas för leveransmetoden samt om frakten ska bli gratis över en viss kostnad.

## test-plugin
Detta plugin testar olika funktioner från både temat och andra plugins från detta projekt. När det aktiveras dyker en ny flik upp i admin-menyn kallat "Test Plugin". I denna flik genomförs ett antal tester för att bevisa att dessa funktioner fungerar korrekt.
