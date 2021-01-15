<h1>EHK Test Plugin</h1>

    <h2>Testning av Luhn-algoritmen</h2>

        <p>Test av personnr "640823-3234" (giltigt personnr.)</p>
        <?php EHKTestPlugin::is_actually_valid_ssn('640823-3234', true); ?>

        <p>Test av personnr "640823-3233" (ogiltigt personnr.)</p>
        <?php EHKTestPlugin::is_actually_valid_ssn('640823-3233', false); ?>

    <h2>Test av longitud och lattitud API</h2>
    <!--API:n ger error ibland för dessa, tror det är att vi ger requests för ofta när båda körs på en gång-->

        <p>Test av korrekta kordinater för Rörbecksgatan 14, Falkenberg</p>
        <?php EHKTestPlugin::is_correct_long_lat("Rörbecksgatan, 14", "Falkenberg", 56.90558, 12.48476); ?>

        <p>Test av inkorrekta kordinater för Rörbecksgatan 14, Falkenberg</p>
        <?php EHKTestPlugin::is_correct_long_lat("Rörbecksgatan, 14", "Falkenberg", 51.52531, 10.39365); ?>

    <h2>Testning av en annan funktion</h2>

        <p>Test av "cache buster" funktion</p>
        <?php EHKTestPlugin::is_cache_busted("1.0"); ?>

    <h2>Testning av testfunktionerna</h2>

        <p>Test av varje funktion med förväntat lyckat test</p>
        <?php EHKTestPlugin::are_the_test_functions_working_correctly(); ?>