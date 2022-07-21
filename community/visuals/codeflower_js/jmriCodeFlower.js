var currentCodeFlower;

var createCodeFlower = function(json) {
    // remove previous flower to save memory
    if (currentCodeFlower) currentCodeFlower.cleanup();
    // adapt layout size to the total number of elements
    //var total = countElements(json);
    w = 1500; //parseInt(Math.sqrt(total) * 5, 10);
    h = 1500; //parseInt(Math.sqrt(total) * 5, 10);
    // create a new CodeFlower
    currentCodeFlower = new CodeFlower("#visualization", w, h).update(json);
};

document.getElementById('part').addEventListener('change', function() {
    d3.json(this.value, createCodeFlower);
});
