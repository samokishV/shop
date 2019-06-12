    var Ziggy = {
        namedRoutes: {"home":{"uri":"home","methods":["GET","HEAD"],"domain":null},"category.show":{"uri":"category\/{catSlug}","methods":["GET","POST","HEAD"],"domain":null},"product.search":{"uri":"product\/search","methods":["POST"],"domain":null},"product.show":{"uri":"product\/{slug}","methods":["GET","HEAD"],"domain":null},"login":{"uri":"login","methods":["GET","HEAD"],"domain":null},"logout":{"uri":"logout","methods":["POST"],"domain":null},"register":{"uri":"register","methods":["GET","HEAD"],"domain":null},"password.request":{"uri":"password\/reset","methods":["GET","HEAD"],"domain":null},"password.email":{"uri":"password\/email","methods":["POST"],"domain":null},"password.reset":{"uri":"password\/reset\/{token}","methods":["GET","HEAD"],"domain":null},"password.update":{"uri":"password\/reset","methods":["POST"],"domain":null},"cart.add":{"uri":"cart\/add","methods":["POST"],"domain":null},"cart.edit":{"uri":"cart\/update\/{productId}","methods":["POST"],"domain":null},"cart.delete":{"uri":"cart\/delete\/{productId}","methods":["POST"],"domain":null},"cart.delete.all":{"uri":"cart\/delete","methods":["POST"],"domain":null},"cart":{"uri":"cart","methods":["GET","HEAD"],"domain":null},"order":{"uri":"order","methods":["GET","HEAD"],"domain":null},"order.history":{"uri":"order\/history","methods":["GET","HEAD"],"domain":null},"admin.user.index":{"uri":"admin\/user","methods":["GET","HEAD"],"domain":null},"user.delete":{"uri":"admin\/user\/delete\/{id}","methods":["DELETE"],"domain":null},"user.add":{"uri":"admin\/user\/add","methods":["GET","HEAD"],"domain":null},"user.edit":{"uri":"admin\/user\/edit\/{id}","methods":["GET","HEAD"],"domain":null},"admin.category.index":{"uri":"admin\/category","methods":["GET","HEAD"],"domain":null},"category.delete":{"uri":"admin\/category\/delete\/{id}","methods":["DELETE"],"domain":null},"category.add":{"uri":"admin\/category\/add","methods":["GET","HEAD"],"domain":null},"category.edit":{"uri":"admin\/category\/edit\/{id}","methods":["GET","HEAD"],"domain":null},"admin.product.index":{"uri":"admin\/product","methods":["GET","HEAD"],"domain":null},"product.add":{"uri":"admin\/product\/add","methods":["GET","HEAD"],"domain":null},"product.edit":{"uri":"admin\/product\/edit\/{id}","methods":["GET","HEAD"],"domain":null},"promo.edit":{"uri":"admin\/product\/edit-promo\/{id}","methods":["GET","HEAD"],"domain":null},"admin.order.index":{"uri":"admin\/order","methods":["GET","HEAD"],"domain":null},"order.edit":{"uri":"admin\/order\/edit\/{id}","methods":["GET","HEAD"],"domain":null},"facebook.redirect":{"uri":"redirect","methods":["GET","HEAD"],"domain":null},"facebook.callback":{"uri":"callback","methods":["GET","HEAD"],"domain":null},"twitter.redirect":{"uri":"redirect\/twitter","methods":["GET","HEAD"],"domain":null},"twitter.callback":{"uri":"callback\/twitter","methods":["GET","HEAD"],"domain":null}},
        baseUrl: 'http://192.168.0.56/',
        baseProtocol: 'http',
        baseDomain: '192.168.0.56',
        basePort: false,
        defaultParameters: []
    };

    if (typeof window.Ziggy !== 'undefined') {
        for (var name in window.Ziggy.namedRoutes) {
            Ziggy.namedRoutes[name] = window.Ziggy.namedRoutes[name];
        }
    }

    export {
        Ziggy
    }
