var add = document.getElementsByClassName('add_to_cart');
//var products = [];

for(i=0 ; i<add.length ; i++){
    add[i].addEventListener('click', (e) => {
        
        let parent = e.target.parentNode;
        let ma = parent.getAttribute('data-ma');
        let list_child = parent.children;
    
        let anh = list_child[0].getAttribute('src');
        let detail_prod = list_child[1].children;
        let decript = detail_prod[0].textContent;
        let cost = detail_prod[1].getAttribute('data-cost');

        let product = new Product(anh, decript, cost, parseInt(0), ma);
        //products.push(product);

        // increase cart number
        cartNumber(product);

    })
}
class Product{
constructor(anh, decript, cost, inCart, ma){
    this.ma = ma;
    this.anh = anh;
    this.decript = decript;
    this.cost = cost;
    this.inCart = inCart;

}
}

// count cart numbers
function cartNumber(product){

    let productNumbers = localStorage.getItem('cartNumbers');

    productNumbers = parseInt(productNumbers);

    if(productNumbers){
        localStorage.setItem('cartNumbers', productNumbers+1);
        document.querySelector('#cartNumbers').innerHTML = productNumbers + 1;
    }else{
        localStorage.setItem('cartNumbers', 1);
        document.querySelector('#cartNumbers').innerHTML = 1;
    }

    setItem(product);
}
// storage item in local storage

function setItem(product){
    let products = localStorage.getItem('products');
    products = JSON.parse(products);

    if(products != null){

        if(products[product.decript] == undefined){
            console.log(product)
                products = {
                ...products,
                [product.decript] : product,
            }
        }
        products[product.decript].inCart += 1;
    }else{
        product.inCart =1;
        
         products = {
            [product.decript] : product,
        }
    }

    localStorage.setItem('products', JSON.stringify(products));
}

// set cart number when load page if cart numbers exist
function oldNumbers(){
    let productNumbers = localStorage.getItem('cartNumbers');
    productNumbers = parseInt(productNumbers);
    if(productNumbers){
        document.querySelector('#cartNumbers').innerHTML = productNumbers;
    }
}

oldNumbers();