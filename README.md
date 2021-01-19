Ett tema och plugins för wordpress projekt som använder woocommerce.

# Installation:
Dra "theme" och "plugins" mapparna från detta projekt in till din egna wordpress-installations wp-content mapp.
Destinationen bör se ut så här: 
"...din-wordpress-installation/wp-content"

# Temat
För att temat ska fungera korrekt så behövs det skapas några ACF-fält. Fälten som behöver skapas är för footerns options page och för kampanj-slidern i headern. För footern behöver ett fält som heter ”Bakgrundsfärg” skapas och det ska vara av typen "Färgväljare". Detta fält ska placeras på inställningssidan (options page) "Footer Settings". Man kan sedan välja bakgrundsfärg för footern med hjälp av "Footer Settings" i adminpanelen. 

För kampanj-slidern behöver ett upprepningsfält som heter "campaign slide" skapas och som placeras där sidmall är standardmall. Detta fält ska ha 4 underfält:
* "image" av typen "Bild"
* "campaign heading" av typen "Text"
* "campagin content" av typen "Textfält"
* "discount" av typen "Text"

Man kan nu gå in på valfri sida och lägga till bilder och innehåll i slidern. 

Tre menyer behöver också skapas. En huvudmeny, en meny för footern och en mobilmeny som man parar ihop med dessa tre menyer som finns listade under "Menyinställningar". Man väljer sedan vilka sidor/kategorier mm man vill ha med i dessa. 

För att visa vart företagets butiker finns på en karta på webbplatsen går man in på "Butiker" i adminpanelen och fyller i företagets adress, samt longitud och latitud. 

# Plugins
Projektet kommer med fyra plugins: "betalnings-plugin", "shippingplugin", "leverans-plugin-2" och "test-plugin".

## betalnings-plugin
Ett plugin som lägger till betalning via faktura från giltigt personnummer. Kunder som väljer att betala med denna metod måste ange giltigt personnummer i kassan för att ordern ska gå igenom.

När pluginet är aktiverat kan betalningsmetoden aktiveras för kunder genom att gå in i Woocommerces inställningar, under "Payments". Aktivera metoden "Faktura" och den bör dyka upp under kassan för kunderna. Du kan även ändra dess titel och beskrivning som syns i kassan genom att klicka på betalningsmetoden och ändra textfälten som då visas upp.

## shippingplugin
Ett leverans plugin som räknar ut priset för leveransen beroende på vikt av beställningen och hur långt avståndet är mellan lager och beställare, som räknas ut i bilväg via en API.

När pluginet är aktiverat kommer det dyka upp en flik i wordpress admin som heter "Frakt priser" där man kan ställa in priser för dem olika viktklasserna.

## leverans-plugin-2
Ännu ett plugin som lägger till en ny leverensmetod, denna gången för att hämta i butik. Kunder som väljer denna leveransmetod får välja mellan butikerna som skapats under temats "Butiker" flik.

När pluginet är aktiverat kan leveransmetoden aktiveras för kunder genom att gå in i Woocommerces inställningar, under "Shipping". Här kan även ett pris sättas för leveransmetoden samt om frakten ska bli gratis över en viss kostnad.

## test-plugin
Detta plugin testar olika funktioner från både temat och andra plugins från detta projekt. När det aktiveras dyker en ny flik upp i admin-menyn kallat "Test Plugin". I denna flik genomförs ett antal tester för att bevisa att dessa funktioner fungerar korrekt.
