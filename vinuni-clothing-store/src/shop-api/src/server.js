const express = require("express");
const app = express();
const port = process.env.APP_PORT || 8080;
const host = "0.0.0.0";

app.use(express.json());
app.use(express.static("public"))

const items = ["Sample 1", "Sample 2", "Sample 3", "Sample 4", "Sample 5", "Sample 6", "Sample 7"]

const items_mapping = {"Sample 1": "/img/item1.png", "Sample 2": "/img/item2.png", "Sample 3": "/img/item3.png", "Sample 4": "/img/item4.png", "Sample 5": "/img/item5.png", "Sample 6": "/img/item6.png", "Sample 7": "/img/item7.png"}

let user_data = [];    

app.get("/items.json", (req, res) => {
    return res.json({"status": 200, "msg": items_mapping});
})

app.route("/users/:id/items.json")  
    .get((req, res) => {
        if (!(req.params.id in user_data) || user_data[req.params.id].length == 0) {
            user_data[req.params.id] = []
            for (var i = 0; i < items.length ; i++)  
            {
                user_data[req.params.id].push(items[i])  
            }
        }
        return res.json({"status": 200, "msg": user_data[req.params.id]})
    })

app.listen(port, host, () => {
    console.log(`Example app listening at http://localhost:${port}`)
  })
