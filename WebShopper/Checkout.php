<?php
require('Product.php');


//var_dump($_GET);




//variables and constants
const MB_PRICE = 4.5;
$total = 0;
$bogofSavings = 0;
$multiBuySavings = 0;
$totalSavings = 0;

$basket = array();
// Create the new items and add them to the inventory array
$inventory = array();
array_push(
    $inventory,
    new Product("FR1", "Fruit Tea", 3.11, "bogof"),
    new Product("SR1", "Strawberries", 5.0, "multiBuy"),
    new Product("CF1", "Coffee", 11.23, "normal")
);






function checkout($productId)
{
    global $total, $inventory, $bogofSavings, $multiBuySavings, $totalSavings;

    // Check the inventory items to find the matching product code
    foreach ($inventory as $product) {
        // If the product ID is found add the item
        if ($product->getId() == $productId) {
            // increments how many there are of a specific item
            $product->setCount($product->getCount() + 1);

            // Checks the offer status of the item
            switch ($product->getOffer()) {
                case 'bogof':
                    /* if BOGOF then DIV the count by 2, multiply by price. To
                        this add the MOD 2 times the price. The total price needs
                        updating along with the total savings and the bogof savings*/
                    $tempTotal = (intdiv($product->getCount(), 2) + ($product->getCount() % 2)) * $product->getPrice();
                    $total += $tempTotal;
                    $bogofSavings += ($product->getCount() * $product->getPrice()) - $tempTotal;
                    $totalSavings += $bogofSavings;
                    break;
                case 'multiBuy':
                    /* if multiBuy then if the count is >= 3, apply the new price of £4.50.
                        Then calculatet the total based on this price. The total price needs
                        updating along with the total savings and the bogof savings*/
                    $tempPrice = 0;
                    if ($product->getCount() >= 3) {
                        $tempPrice = MB_PRICE;
                    } else {
                        $tempPrice = $product->getPrice();
                    }

                    $tempTotal = $product->getCount() * $tempPrice;
                    $total += $tempTotal;
                    $multiBuySavings += (($product->getCount() * $product->getPrice()) - $tempTotal);
                    $totalSavings += $multiBuySavings;
                    break;
                default:
                    /* Total = count * price. Update the total.*/
                    $total += ($product->getCount() * $product->getPrice());
                    break;
            }
        }
    }
}

if (isset($_GET['item'])) {
    checkout(($_GET['item']));
    $_GET['item'] = "";
}

function displayBasket()
{
    global $total, $inventory, $bogofSavings, $multiBuySavings, $totalSavings, $fmt;

    foreach ($inventory as $product) {
        $tempPrice = $product->getPrice();
        if ($product->getOffer() == "multiBuy" && $product->getCount() >= 3) {
            $tempPrice = MB_PRICE;
        }
        print($product->getCount() . ' x ' . $product->getId() . ' - ' . $product->getName() . ' @ £' . $tempPrice . '<br>');
    }
}



function siteHeader()
{
    print '<!DOCTYPE html>
    <html lang="en-GB">
    
    <head>
        <title>WebShopper App</title>
        <meta charset="UTF-8">
        <meta name="description" content="Shopping and Checkout Application">
        <meta name="robots" content="index, follow">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/main.css">
    </head>
    
    <body>
        <header>
            <div><img src="images/checkout.png" alt="WebShopper Logo" width="35" height="35"></div>
            <h1>WebShopper</h1>
        </header>';
}

function siteFooter()
{
    print ' <footer>
                <div class="center">WebShopper &copy; <script type="text/javascript">document.write(new Date().getFullYear());</script></div>
            </footer>
            <script type="text/javascript" src="scripts/main.js"></script>
            </body>

        </html>';
}

function siteMain()
{
    global $inventory;
    print '<section class="main-content">
        <section class="products">
            <form action="Checkout.php" method="get">';

    foreach ($inventory as $item) {
        print '<button class="item" id="' . $item->getId() . '" type="submit" name="item" value="' . $item->getId() . '">' . $item->getName() . '</button>';
    }
    print '</form>
            
        </section>
        <aside class="basket">
            <h2>Shopping Basket</h2>
            <h3>Items</h3>';

    print '    
            <div id="basket-items" class="basket-items"></div>
            <br><br>
            <hr><hr>
            <h3>Totals</h3>
            <div id="total" class="total">' . displayBasket() . '</div>
        </aside>
    </section>';
}

function displayPage()
{
    global $inventory;
    siteHeader();
    siteMain();
    siteFooter();
}


displayPage();
