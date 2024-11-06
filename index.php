<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Cake Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <main>
        <section>
            <h1>Order your favorite cakes with ease and have them delivered to your doorstep.</h1>
            <div class="search">
                <input type="text" class="search-bar" placeholder="Browse for cakes">
                <button class="search-button">Search</button>
            </div>

            
        </section>
        <section>
            <h1>FEATURED PRODUCTS</h1>

            <div class="cake-grid">
                <div class="cake-item">
                    <img src="img/cake2.jpg" alt="Vanilla Cake">
                    <h3>Vanilla Cake</h3>
                    <p>Price: $20.00</p>
                    <button>Add to Cart</button>
                </div>
                <div class="cake-item">
                    <img src="img/lemon.jpg" alt="Lemon Cake">
                    <h3>Lemon Cake</h3>
                    <p>Price: $22.00</p>
                    <button>Add to Cart</button>
                </div>
                <div class="cake-item">
                    <img src="img/carrot.jpg" alt="Carrot Cake">
                    <h3>Carrot Cake</h3>
                    <p>Price: $28.00</p>
                    <button>Add to Cart</button>
                </div>
                <div class="cake-item">
                    <img src="img/black.jpg" alt="Black Forest Cake">
                    <h3>Black Forest Cake</h3>
                    <p>Price: $35.00</p>
                    <button>Add to Cart</button>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>
