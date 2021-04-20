function currentpage() {
    // GET CURRENT PAGE 
    let page = (window.location.pathname).split('/');
    page = page[page.length - 1].split('.')[0];
    return page;
}

function get(field = false, val = false) {
    //   GET TABLE VALUES
    //   ASYNC DOES NOT WORK 
    //
    // $.get(`api/get.php?page=${page}`, (data) => {
    //     $(".update-table")[0].innerHTML = data;
    // });
    url = `api/get.php?page=${currentpage()}`;
    if (field && val) {
        url = `api/get.php?page=${currentpage()}&field=${field}&val=${val}`;
    } else if (val) {
        url = `api/get.php?page=${currentpage()}&val=${val}`;
    }
    $.ajax({
        url: url,
        type: 'GET',
        async: false,
        success: function (res) {
            $(".update-table")[0].innerHTML = res;
        }
    });
    $.ajax({
        url: `api/count.php?page=${currentpage()}`,
        type: 'GET',
        async: false,
        success: function (res) {
            $(".counted")[0].innerHTML = res;
        }
    });
    if (currentpage() == 'product') {
        $.ajax({
            url: 'api/get_suppliers.php',
            type: 'GET',
            async: false,
            success: function (res) {
                $(".supplierList")[0].innerHTML = res;
            }
        });
    }
}

function add(data) {
    // ADD PRODUCT TO DB AND UPDATE TABLE VALUES
    // $.post(`api/add.php?page=${currentpage()}`, {
    //     category: category,
    //     product: product,
    //     cost: cost,
    //     stock: stock,
    //     description: description
    // }, function () {
    //     get();
    //     close();
    // });
    $.post(`api/add.php?page=${currentpage()}`, data, () => {
        get();
        close();
    });
}

function addStocked(data) {
    $.post('api/addstock.php', data, () => {
        get();
        close();
        clear(true);
    });
}

function close() {
    // CLOSE THE POPUP OR MODAL AND CLEAR THE VALUES INSIDE
    $('.close').click();
    clear();
}

function clear(modal = false) {
    // CLEAR VALUES
    if (modal)
        $('.popup1 input').val("");
    else {
        $('.popup input').val("");
        $('.popup textarea').val("");
    }
}

$('.add').click(() => {
    var data = $('.popup').serializeArray().reduce(function (obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});

    // var category = $('input[name="category"]').val();
    // var product = $('input[name="product"]').val();
    // var cost = $('input[name="cost"]').val();
    // var stock = $('input[name="stock"]').val();
    // var description = $('textarea[name="description"]').val();
    if (data['category'] == "") {
        alert('Category is empty');
    } else if (data['product'] == "") {
        alert('Product is empty');
    } else if (data['cost'] == "") {
        alert('Cost is empty');
    } else if (data['description'] == "") {
        alert('Description is empty');
    } else if (data['stock'] == "") {
        alert('Stock is empty');
    } else {
        if ($('.add')[0].innerHTML == "<span>Edit</span>") {
            edit_send(data);
        } else {
            add(data);
        }
    }
});

$('.addStock').click(() => {
    var data = $('.popup1').serializeArray().reduce(function (obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    if (data['quantity'] == "") {
        alert('Quantity is empty');
    } else if (data['Unit'] == "0") {
        alert('Unit is empty');
    } else if (data['price'] == "") {
        alert('Price is empty');
    } else if (data['supplier'] == 0) {
        alert('Supplier is empty');
    } else {
        addStocked(data);
    }
});

function deleted(id = false) {
    if (confirm('Are you sure you want to delete this?')) {
        var count = $('.minicheck:checked');
        var collect = [];
        if (count.length == 0 && id) {
            collect = [id];
        } else if (count.length > 0) {
            for (let i = 0; i < count.length; i++) {
                collect.push(count[i].value);
            }
        }
        $.post(`api/delete.php?page=${currentpage()}`, {
            id: collect
        }, function () {
            get();
        });
    }
}

$(document).on('click', '.checkAll', () => {
    $(".minicheck").prop('checked', $('.checkAll')[0].checked);
});

$('.delete_head').click(() => {
    deleted();
});

function search(field, val) {
    alert('search func')
    $.get(`api/get.php?page=${currentpage()}&field=${field}&val=${val}`, (data) => {
        $(".update-table")[0].innerHTML = data;
    });
}

// function edit(rec_id, category, product, cost, stock, description) {
//     $('input[name="category"]').val(category);
//     $('input[name="product"]').val(product);
//     $('input[name="cost"]').val(cost);
//     $('input[name="stock"]').val(stock);
//     $('textarea[name="description"]').val(description);
//     $('input[name="rec_id"]').val(rec_id);
//     $('.add')[0].innerHTML = "<span>Edit</span>";
//     $('.modaltitle')[0].innerHTML = `Edit ${ currentpage() }`;
// }

function edit(arr) {
    var data = $('.popup').serializeArray().reduce(function (obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    var keys = Object.keys(data);
    for (let i = 0; i < keys.length; ++i) {
        $(`[name = ${keys[i]}]`).val(arr[i]);
    }
    $('.add')[0].innerHTML = "<span>Edit</span>";
    $('.modaltitle')[0].innerHTML = `Edit ${currentpage()}`;
}

function addStock(id, product) {
    $('.modaltitle1')[0].innerHTML = `Add stock in product ${product}`;
    $('[name="rec_id"]').val(id);
}

function edit_send(data) {
    $.post(`api/edit.php?page=${currentpage()}`, data, () => {
        get();
        close();
    });
}


$('.search_butt').click(() => {
    var val = $('input[name="val"]').val();
    var field = $('.selectedha').val();
    get(field, val);
});

$('.addbutt').click(() => {
    clear();
    $('.add')[0].innerHTML = "<span>Add</span>";
    $('.modaltitle')[0].innerHTML = `Add ${currentpage()}`;
});


get();