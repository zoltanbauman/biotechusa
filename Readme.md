# BioTechUSA teszfeladat

## Interfészek
A `PublishableInterface` garantálja az entitások publikálásához szükséges metódusokat.
A főbb metódusokat a `Publishable` trait tartalmazza, kivéve a `isPublishable` metódust, amit egyedileg minden 
entitás maga kezel.

A `CampaignableInterface` határozza meg, hogy egy entitás, felhasználható-e a kampány elemeként. 
A hozzá tartozó metódusokat a `Campaignable` trait tartalmazza.

## Entitások
* `Product`: Bármikor publikálható entitás
* `BlogPost`: Csak hétvégén publikálható entitás
* `Cupon`: A hónap első és utolsó három napjában aktiválható csak
entitás
* `Campaign`: Kezdő és végdátummal rendelkező entitás, amihez hozzá lehet adni `CampaignableInterface`-el rendelkező 
  entitásokat.
  
Egy kampány akkor publikálható, ha az összes hozzá tartozó elem 
* már publikált vagy a kampány publikálásának pillanatában publikálható
* és nem kapcsolódik más már publikált és még éppen futó kampányhoz

A kampány publikálása automatikusan az elemek publikálását is maga után vonja.

**Fontos** a kampány kezdetét és lejáratát egy ütemezett feladat figyelné, ami a kampány indítását és
lejárat kezelné. Ennek megfelelően a kezdetkor kapcsolná be, és lejáratkor kapcsolná ki.



