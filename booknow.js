        const models = {
            suzuki: ["Suzuki Address 115", "Suzuki Skydrive 125", "Suzuki BurgmanStreet","Suzuki Raider R150","Suzuki Gixxer F1","Suzuki GSX-S50","Suzuki GSX-R150","Suzuki Gixxer 250","Suzuki V-Strom 250 SX","Suzuki SV 650A","Suzuki V-Strom 650","Suzuki GSX-750"],
            honda: ["Honda TMX 125 Alpha","Honda Dio","Honda Beat","Honda XR150L","Honda CRF150L","Honda CBR150R","Honda CB500F","Honda Rebel 500","SHonda CB650R","Honda Transalp XL750","Honda Africa Twin","Honda Gold Wing 1800"],
            bmw: ["BMW G 310 R","HBMW G 310 GS","BMW F 750 GS","BMW F 900 R","BMW F 850 GS","BMW F 900 XR","BMW R nine T Pure 1200","BMW R nine T Scrambler","BMW R nine T Urban","BMW R nine T 1200","BMW S 1000 R","BMW R 1250 RT"],
            kawasaki: ["Kawasaki Versys-X 300","Kawasaki Ninja 400","Kawasaki Ninja 500","Kawasaki ZX-25R","Kawasaki Z650","Kawasaki Ninja 650","Kawasaki Z900","Kawasaki ZX-6R","Kawasaki Ninja 1000 SX","Kawasaki Z H2","Kawasaki Ninja ZX-10R","Kawasaki Ninja H2 1000"],
            ktm: ["KTM 200 Duke","KTM RC 200","KTM 390 Duke","KTM RC 390","KTM 390 Adventure","KTM 790 Duke","KTM 690 Duke","KTM 250 SX-F","KTM 300 EXC-F TPI","KTM 790 Adventure S","KTM 450 SX-F","KTM 1290 Super Duke GT"],
            royal_enfield: ["Royal Enfield Classic 350","Royal Enfield Hunter 350","Royal Enfield Meteor 350","Royal Enfield Scram 411","Royal Enfield Himalayan 411","Royal Enfield Interceptor 650","Royal Enfield Continental GT 650"]
        };

        const prices = {
            "Suzuki Address 115": "₹66,999  /-",
            "Suzuki Skydrive 125": "₹70,999/-",
            "Suzuki BurgmanStreet": "₹80,999/-",
            "Suzuki Raider R150": "₹100,999/-",
            "Suzuki Gixxer F1": "₹105,999/-",
            "Suzuki GSX-S150": "₹112,999/-",
            "Suzuki GSX-R150": "₹150,999/-",
            "Suzuki Gixxer 250": "₹182,999/-",
            "Suzuki V-Strom 250 SX": "₹229,999/-",
            "Suzuki SV 650A": "₹329,999/-",
            "Suzuki V-Strom 650": "₹350,999/-",
            "Suzuki GSX-750": "₹380,999/-",
            "Honda TMX 125 Alpha": "56,999/-",
            "Honda Dio": "62,999/-",
            "Honda Beat": "69,999/-",
            "Honda XR150L": "96,999/-",
            "Honda CRF150L": "₹105,999/-",
            "Honda CBR150R": "₹183,999/-",
            "Honda CB500F": "₹200,999/-",
            "Honda Rebel 500": "₹282,999/-",
            "Honda CB650R": "₹300,999/-",
            "BMW G 310 R": "₹300,999/-",
            "BMW G 310 GS": "₹320,999/-",
            "BMW F 750 GS": "₹765,999/-",
            "BMW F 900 R": "₹775,999/-",
            "BMW F 850 GS": "₹855,999/-",
            "BMW F 900 XR": "₹900,999/-",
            "BMW R nine T Pure 1200": "₹1,000,999/-",
            "BMW R nine T Scrambler": "₹1,100,999/-",
            "BMW R nine T Urban": "₹1,150,999/-",
            "BMW R nine T 1200": "₹1,190,999/-",
            "BMW S 1000 R": "₹1,250,999/-",
            "BMW R 1250 RT": "₹2,300,999/-",
            "Kawasaki Versys-X 300" : "₹270,999/-",
            "Kawasaki Ninja 400": "₹300,999/-",
            "Kawasaki Ninja 500": "₹350,999/-",
            "Kawasaki ZX-25R": "₹380,999/-",
            "Kawasaki Z650": "₹390,999/-",
            "Kawasaki Ninja 650": "₹400,999/-",
            "Kawasaki Z900": "₹420,999/-",
            "Kawasaki ZX-6R": "₹450,999/-",
            "Kawasaki Ninja 1000 SX": "₹470,999/-",
            "Kawasaki Z H2": "₹490,999/-",
            "Kawasaki Ninja ZX-10R": "₹500,999/-",
            "Kawasaki Ninja H2 1000": "₹600,999/-",
            "KTM 200 Duke": "₹178,999/-",
            "KTM RC 200": "₹198,999/-",
            "KTM 390 Duke": "₹318,999/-",
            "KTM RC 390": "₹335,999/-",
            "KTM 390 Adventure": "₹338,999/-",
            "KTM 790 Duke": "₹599,999/-",
            "KTM 690 Duke": "₹600,999/-",
            "KTM 250 SX-F": "₹724,999/-",
            "KTM 300 EXC-F TPI": "₹740,999/-",
            "KTM 790 Adventure S": "₹748,999/-",
            "KTM 450 SX-F": "₹760,999/-",
            "KTM 1290 Super Duke GT": "₹1,200,999/-",
            "Royal Enfield Classic 350": "₹249,999/-",
            "Royal Enfield Hunter 350": "₹231,999/-",
            "Royal Enfield Meteor 350": "₹240,999/-",
            "Royal Enfield Scram 411": "₹311,999/-",
            "Royal Enfield Himalayan 411": "₹354,999/-",
            "Royal Enfield Interceptor 650": "₹446,999/-",
            "Royal Enfield Continental GT 650": "₹459,999/-"
        };

        function updateModels() {
            const brandSelect = document.getElementById("brand");
            const modelSelect = document.getElementById("model");
            const selectedBrand = brandSelect.value;

            // Clear the model dropdown
            modelSelect.innerHTML = '<option value="">--Select Model--</option>';

            if (selectedBrand) {
                const brandModels = models[selectedBrand];
                brandModels.forEach(model => {
                    const option = document.createElement("option");
                    option.value = model;
                    option.text = model;
                    modelSelect.add(option);
                });
            }
        }

        function updatePrice() {
            const modelSelect = document.getElementById("model");
            const priceInput = document.getElementById("price-input");
            const selectedModel = modelSelect.value;

            if (selectedModel) {
                priceInput.value = prices[selectedModel];
                document.getElementById("price-display").textContent = prices[selectedModel];
            } else {
                priceInput.value = "";
                document.getElementById("price-display").textContent = "Select a model to see the price";
            }
        }

