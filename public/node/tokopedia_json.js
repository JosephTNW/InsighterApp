import puppeteer from "puppeteer";

const pages = process.argv[3];
const prod_query = process.argv[2];

const getProducts = async () => {
    // Start a Puppeteer session with:
    // - a visible browser (`headless: false` - easier to debug because you'll see the browser in action)
    // - no default viewport (`defaultViewport: null` - website page will in full width and height)
    const browser = await puppeteer.launch({
        headless: false,
        defaultViewport: null,
    });

    // Open a new page
    const page = await browser.newPage();

    for (let i = 1; i < pages; i++) {
        // On this new page:
        // - open the website
        // - wait until the dom content is loaded (HTML is ready)
        await page.goto(
            "https://www.tokopedia.com/search?navsource=&page=" +
                i +
                "&q=" +
                prod_query +
                "&srp_component_id=02.01.00.00&srp_page_id=&srp_page_title=&st=product",
            {
                waitUntil: "domcontentloaded",
            }
        );

        // Get page data
        const products = await page.evaluate(() => {
            const productList = document.querySelectorAll(".css-974ipl");

            return Array.from(productList).map((product) => {
                // Fetch the sub-elements from the previously fetched product element
                const text = product.querySelector(
                    ".prd_link-product-name"
                ).innerText;
                const price = product.querySelector(
                    ".prd_link-product-price"
                ).innerText;
                const store = product.querySelector(
                    ".prd_link-shop-name"
                ).innerText;
                const loc_store =
                    product.querySelector(".prd_link-shop-loc").innerText;
                // const rating    = product.querySelector(".prd_rating-average-text ").innerText;
                // const extra     = product.querySelector(".prd_label-integrity").innerText;

                return { 
                    "title": text,
                    "price": price,
                    "store": store,
                    "location": loc_store
                };
            });
        });

        // Display the products
        console.log(products);
        console.log("----------------------" + i + "------\n");

        await page.goto(
            "https://www.tokopedia.com/search?navsource=&page=5&q=brown%20sugar&srp_component_id=02.01.00.00&srp_page_id=&srp_page_title=&st=product",
            {
                waitUntil: "domcontentloaded",
            }
        );

        // // Close the browser
    }
    await browser.close();
};

// Start the scraping
getProducts();
