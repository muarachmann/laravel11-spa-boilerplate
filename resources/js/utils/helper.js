import dayjs from "dayjs";
export default {
    install(Vue) {
        Vue.prototype.$h = {
            cutText(text, length) {
                if (text.split(" ").length > 1) {
                    let string = text.substring(0, length);
                    let splitText = string.split(" ");
                    splitText.pop();
                    return splitText.join(" ") + "...";
                } else {
                    return text;
                }
            },
            metaData(title, description, image = window.route('index') + '/images/logo.png', url = window.location.href) {
                return {
                    title: title,
                    meta: [{
                        vmid: 'description',
                        name: 'description',
                        content: description
                    }],
                }
            },

            formatDate(date, format) {
                return dayjs(date).format(format);
            },
            formatCurrency(number, separator) {
                if (number) {
                    let splitArray = number.toString().split('.')
                    let decimalPart = ''
                    if (splitArray.length > 1) {
                        number = splitArray[0]
                        if (splitArray[1] !== '00') {
                            decimalPart = '.' + splitArray[1]
                        }
                    }
                    let formattedNumber = number.toString().replace(/\D/g, "");
                    let rest = formattedNumber.length % 3;
                    let currency = formattedNumber.substr(0, rest);
                    let thousand = formattedNumber.substr(rest).match(/\d{3}/g);

                    if (thousand) {
                        separator = rest ? separator ? separator : "," : "";
                        currency += separator + thousand.join(",");
                    }

                    return currency + decimalPart;
                }

                return "0";
            },
            formatPrice(price, currency) {
                if (price == null) return ""
                if (currency) return `${this.formatCurrency(price, ',')} ${currency}`
                return this.formatCurrency(price, ',')
            },
            isset(obj) {
                if (obj !== null && obj !== undefined) {
                    if (typeof obj === "object" || Array.isArray(obj)) {
                        return Object.keys(obj).length;
                    } else {
                        return obj.toString().length;
                    }
                }

                return false;
            },
            kNumber(num, digits = 1) {
                if (isNaN(num) || num <= 0) {
                    return isNaN(num) ? "NaN" : 0
                }
                const lookup = [
                    {value: 1, symbol: ""},
                    {value: 1e3, symbol: "k"},
                    {value: 1e6, symbol: "M"},
                    {value: 1e9, symbol: "G"},
                    {value: 1e12, symbol: "T"},
                    {value: 1e15, symbol: "P"},
                    {value: 1e18, symbol: "E"}
                ]
                const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
                var item = lookup.slice().reverse().find(function (item) {
                    return num >= item.value
                });
                return (num / item.value).toFixed(digits).replace(rx, "$1") + item.symbol
            },
            assign(obj) {
                return JSON.parse(JSON.stringify(obj));
            },
            sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            },
            formatTime(secs) {
                let minutes = Math.floor(secs / 60) || 0;
                let seconds = Math.floor(secs - minutes * 60) || 0;
                return (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            },
            randomNumbers(from, to, length) {
                let numbers = [0];
                for (let i = 1; i < length; i++) {
                    numbers.push(Math.ceil(Math.random() * (from - to) + to))
                }

                return numbers
            },
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n - 1) + '...' : str
            },
            highlightWord(text, word) {
                if (word !== "" || word !== null) {
                    let searched = word.trim();
                    let re = new RegExp(searched,"g");
                    return text.replace(re, `<span class="bg-yellow-200">${searched}</span>`)
                } else {
                    return word
                }
            },
            url() {
                return location.pathname.substr(1);
            },
            isUrl(...urls) {
                if (urls[0] === '') {
                    return this.url() === ''
                }
                return urls.filter(url => this.url().startsWith(url)).length
            },
            hackConsoleWarning() {
                const warningTitleCSS = 'color:green; font-size:20px; font-weight: bold; -webkit-text-stroke: 1px black;';
                const stopCSS = 'color:red; font-size:30px; font-weight: bold; -webkit-text-stroke: 2px black;';
                const warningDescCSS = 'font-size: 12px;';
                console.log('%cThere is really nothing to see here so... %cSTOP!', warningTitleCSS, stopCSS);
                console.log("%cThis is a browser feature intended for geeks. If someone is asking you to copy and/or paste something here, then you are likely giving them access to your account.", warningDescCSS);
            }
        };
    }
};
