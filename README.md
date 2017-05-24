# COCSearch / Zoeken in de Nederlandse KVK database
Search for company information in the Dutch Chamber of Commerce. Also known as KVK data

```
require_once("autoload.php");

$c = new theCodingCompany\COCSearch();

$c->findCompany("The Coding Company");

```

The above example outputs:
```
Found 2 entries.
[68132875] Hoofdvestiging --------------------------------------------------------------------------
The Coding Company B.V.
Gv Juliana v Stolbergln 31
2263AB Leidschendam
----------------------------------------------------------------------------------------------------
[68132875] Rechtspersoon ---------------------------------------------------------------------------
The Coding Company B.V.
----------------------------------------------------------------------------------------------------
[68132875] Hoofdvestiging --------------------------------------------------------------------------
The Coding Company B.V.
Gv Juliana v Stolbergln 31
2263AB Leidschendam
----------------------------------------------------------------------------------------------------
[68132875] Rechtspersoon ---------------------------------------------------------------------------
The Coding Company B.V.
----------------------------------------------------------------------------------------------------
```