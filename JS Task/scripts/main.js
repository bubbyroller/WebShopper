//List of products and their prices
var products = [["CF1", "Coffee", 11.23, 0, 0], 
                ["SR1", "Strawberries", 5.00, 0, 0], 
                ["FR1", "Fruit Tea", 3.11, 0, 0]];




// Tested and working
function addItem(item){

    var label;

    products.forEach(product => {
        
        if(product[0] == item){
            
            label = getLabel(item);
            product[3] += 1;
            label.innerHTML = product[3];
            basketUpdate();
            displayTotal();
        }
    });
}

function removeItem(item){
    var label;

    products.forEach(product => {

        if(product[0] == item){
            label = getLabel(item);
            if(product[3] > 0){
                product[3] -= 1;
            }else{
                product[3] = 0;
            }
            label.innerHTML = product[3];
            basketUpdate();
            displayTotal();
        }
        
    });
}

function basketUpdate(){
    document.getElementById("basket-items").innerHTML = "";
    var str = "";
    calculateTotal();
    products.forEach(product => {
        if(product[3] > 0){
            var s = `${product[3]} x ${product[0]} - ${product[1]} @ £${product[2].toFixed(2)}<br>`;
            str += s;
        }
    });
    
    var element = document.createElement('label');
    element.innerHTML = str;
    document.getElementById("basket-items").appendChild(element);

}

function getLabel(item){
    var label;
    switch(item){
        case 'CF1':
            label = document.getElementById("lbl_coffee");
            break;
        case 'SR1':
            label = document.getElementById("lbl_strawberries");
            break;
        case 'FR1':
            label = document.getElementById("lbl_fruitTea");
            break;
        default:
            label = null;
            break;
    }
    return label;
}

function calculateTotal(){
    var total = 0;
    products.forEach(product => {
        switch(product[0]){
            case 'SR1':
                multiBuy(product);
                break;
            case 'FR1':
                bogof(product);
                break;
            default:
                normalBuy(product)
                break;
        }
    });
}

function bogof(product){
    if(product[3] > 1){
        product[4] = ((Math.floor(product[3]/2) * product[2]) + ((product[3] % 2) * product[2]));
    }else{
        product[4] = (product[3] * product[2]);
    }
}

function multiBuy(product){
    if(product[3] >= 3){
        product[2] = 4.5;
    }else{
        product[2] = 5.0;
    }
    product[4] = product[3] * product[2];
}

function normalBuy(product){
    product[4] = (product[3] * product[2]);
}

function displayTotal(){

    document.getElementById("total").innerHTML = "";

    var originalTotal = 0;
    var savingsTotal = 0;
    var bogofSavings = 0;
    var multiBuySavings = 0;

    products.forEach(product => {
        switch(product[0]){
            case "CF1":
                originalTotal += (product[3] * 11.23);
                savingsTotal += product[4];
                break;
            case "SR1": 
                originalTotal += (product[3] * 5);
                savingsTotal += product[4];
                multiBuySavings = (product[3] * 5) - product[4];
                break;
            case "FR1":
                originalTotal += (product[3] * 3.11);
                savingsTotal += product[4];
                bogofSavings = (product[3] * 3.11) - product[4];
                break;
            default:
                break;
        }
    });


    var str = `<b>Total: £${savingsTotal.toFixed(2)}</b><br>
                BOGOF Savings: £${bogofSavings.toFixed(2)}<br>
                Multibuy Savings: £${multiBuySavings.toFixed(2)}<br>
                Total Savings: £${(bogofSavings + multiBuySavings).toFixed(2)}<br><br>
                Thank you for your custom, please come again.<br>`;

    var element = document.createElement('label');
    element.innerHTML = str;
    document.getElementById("total").appendChild(element);
}