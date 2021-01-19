# Skaičiavimu sistema
Įvedus į CalculationSystem() masyvą ir iškvietus binary(), octal(), hexadecimal() ir decimal() gaunama dvejetainė, aštuntainė, šešioliktainė ir dešimtainė skaičiavimo sistema iš masyvo antras nuo pradžių ir treąias nuo pabaigos.

```php
$numberCount = new CalculationSystem($asoc);

echo $numberCount->binary();
echo "<br>";
echo $numberCount->octal();
echo "<br>";
echo $numberCount->hexadecimal();
echo "<br>";
echo $numberCount->decimal();
echo "<br>";
```

## Dvejetainė skaičiavimo sistema
Dėl paprasto įgyvendinimo skaitmeninėje elektronikoje naudojant loginius elementus, dvejetainė skaičiavimo sistema yra naudojama kompiuteriuose ir kituose elektroniniuose prietaisuose.

## Aštuntainė skaičiavimo sistema
Aštuntainė skaičiavimo sistema naudoja skaitmenis nuo 0 iki 7. Iš dešimtainės skaičiavimo sistemos, kurią dažniausiai naudojame, skačiai gali būti lengvai konvertuojami į aštuntainės skaičiavimo sistemos skaičių.

## Šešioliktainė skaičiavimo sistema
Programavime labai paplitusi šešioliktainė skaičiavimo sistema, kur papildomi skaitmenys žymimi raidėmis (10 = A, 11 = B, 12 = C, 13 = D, 14 = E, 15 = F). Pagrindinis jos privalumas – iš šešioliktainės sistemos nesunku net ir mintinai versti į dvejetainę ir atgal (keturi dvejetainės sistemos skaitmenys atitinka vieną šešioliktainės sistemos skaitmenį).
