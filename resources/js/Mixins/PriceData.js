const exceptPriceKeys = ['date']
const PriceData = {
    methods: {
        parsedPriceData(data) {
            let items = {},key;
            for(key in data) {
                if(exceptPriceKeys.indexOf(key) !== -1) {
                    continue
                }
                switch (key) {
                    case 'is_saison':
                        items["Saison"] = !!data[key] ? 'Ja' : 'Nein'
                        break
                    case 'persons':
                        items["Anzahl Personen"] = data[key]
                        break
                    case 'car_length':
                        items["Wohnwagen Länge"] = data[key] + " m"
                        break
                    case 'price_per_person':
                        items["Preis pro Person"] = data[key] + " €"
                        break
                    case 'sum_person_price':
                        items["Preis Summe Personen"] = data[key] + " €"
                        break
                    case 'electric_per_day':
                        items["Strompreis pro Tag"] = data[key] + " €"
                        break
                    case 'car_price_per_day':
                        items["Wohnwagenpreis pro Tag"] = data[key] + " €"
                        break
                    case 'sum_price':
                        items["Preissumme pro Tag"] = "<b class='text-red-500'>"+ data[key] + " €</b>"
                        break
                    default:
                        items[key] = data[key]
                        break
                }
            }
            return items
        }
    }
}
export default PriceData
