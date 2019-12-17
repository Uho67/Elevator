define([], function () {
    return function (config, node) {
        node.onclick = function () {
            document.location.href = config.path + node.id;
        }
    }
});