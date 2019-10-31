define(['jquery'], function ($)
{
    return function (config,node)
    {
        console.log(config.path,node);
        node.onclick = function (){
            document.location.href = config.path+node.id;
            console.log(node.id);
        }
    }
});