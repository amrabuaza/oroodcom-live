function addChiledToNode(node, person) {
    let li = document.createElement("li");
    node.appendChild(li);
    let rootNode = document.createElement("p");
    var s = 100
    rootNode.innerHTML = '<a onclick="viewPerson(' + person.id + ')" data-person-id="' + person.id + '" class="person">' + person.name + '</a>';

    li.appendChild(rootNode.childNodes[0])
    if (person.childs.length > 0) {
        let ui = li.appendChild(document.createElement("ul"));
        for (let i = 0; i < person.childs.length; i++) {
            addChiledToNode(ui, person.childs[i])
        }
    }
}

function viewPerson(id) {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}

function myFunction(s) {
    // alert(s)
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}

$(document).ready(function () {
    $("a").click(function () {
        alert("The paragraph was clicked.");
    });
});

$(document).ready(function () {
    $.get("http://admin.oroodcom.com/private-api/person/get-all", function (data) {
        $(".result").html(data);
        let person = data;
        let tree = document.getElementById('tree');
        let ui = tree.appendChild(document.createElement("ul"));
        addChiledToNode(ui, person);
        console.log(data)
    });

    $("a").click(function () {
        alert("The paragraph was clicked.");
    });

    $(".person-body").click(function () {
        console.log("test");
    });
});

