let itemContainerElement = document.querySelector(".items-container");
const items = [
    {
        id: '001',
        image: 'nike running shoes.png',
        image_price: '$180',
        company: 'Nike',
        item_name: 'Nike Interact Run',
    },
    {
        id: '002',
        image: 'nike footballboot.png',
        image_price: '$30',
        company: 'Nike',
        item_name: 'Nike Mercurial Vapor 16 Academy',
    },
    {
        id: '003',
        image: 'barcajersey.png',
        image_price: '$60',
        company: 'Nike',
        item_name: 'Barca Jersey',
    },
    {
        id: '004',
        image: 'hockeyboot.png',
        image_price: '$400',
        company: 'XLP',
        item_name: 'Hockey Shoes',
    }
];

console.log(items)
let innerHTML = "";
items.forEach(item => {
    innerHTML += `
        <img class="newarrival" src="${item.image}" />
        <div class="newarrival productdetails">${item.image_price}</div>
        <div class="newarrival productdetails productbrand">${item.company}</div>
        <div class="newarrival productdetails">${item.item_name}</div>
        <button class="buttons add-to-cart" onclick="addToCart()">Add to Cart</button>
    `;
});

itemContainerElement.innerHTML = innerHTML;

function addToCart() {
    // Define the addToCart function
    console.log("Item added to cart");
}