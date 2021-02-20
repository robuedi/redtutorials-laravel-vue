
$(document).ready(function() {

    //get data
    var curses_hierarchy = JSON.parse($('[data-curses-hierarchy-map]').attr('data-curses-hierarchy-map'));

    var children_hidden = $('.curses-chapters-tree').attr('data-children-display');

    var children_style = "";
    var start_icon = "fa-minus";
    if(children_hidden == 'false')
    {
        children_style = "display:none";
        start_icon = "fa-plus";
    }

    var html = {content: ''};

    var doc_type = {
        'course' : 'fa-book',
        'chapter' : 'fa-bookmark-o',
        'lesson' : 'fa-file-text-o'
    };

    //loop through courses
    for(var i = 0; i < curses_hierarchy.length; i++)
    {
        //make current item label
        html.content += '<li >' +
                            '<span class="tree-label pointing-'+curses_hierarchy[i].pointing_id+'">' +
                                '<i class="fa '+start_icon+'"></i>&nbsp;&nbsp;&nbsp;' +
                                    '<a href="'+curses_hierarchy[i].link+'">' +
                                        '<i class="fa fa-lg '+doc_type[curses_hierarchy[i].type]+' "></i>&nbsp;&nbsp;'+
                                            curses_hierarchy[i].clear_name+
                                    '</a>' +
                                '<i class=" text-success hidden-'+curses_hierarchy[i].is_public+'" >&nbsp;&nbsp;public</i>' +
                                '<i  class=" text-info hidden-'+curses_hierarchy[i].is_draft+'" >&nbsp;&nbsp;draft</i>' +
                            '</span>';

        if(curses_hierarchy[i].children.length > 0)
        {
            //loop through chapters/lessons children
            getChildren(html, curses_hierarchy[i].children);
        }

        html.content += '</li>';
    }

    if(html.content.length > 0)
    {

        html.content = $('<div class="tree "><ul>'+html.content+'</ul></div>');
    }

    $('.curses-chapters-tree').append(html.content);

    function getChildren(html, children) {
        html.content += '<ul>';
        for(var j = 0; j < children.length; j++)
        {
            var children_ = false;
            var icon = '';
            if(children[j].children.length > 0)
            {
                children_ = true;
                icon = start_icon;
            }

            //make current item label
            html.content += '<li style="'+children_style+'">' +
                                '<span class="tree-label pointing-'+children[j].pointing_id+'">' +
                                    '<i class="fa '+icon+'"></i>&nbsp;&nbsp;&nbsp;' +
                                        '<a href="'+children[j].link+'">' +
                                            '<i class="fa fa-lg '+doc_type[children[j].type]+' "></i>&nbsp;&nbsp;' +
                                                children[j].clear_name+
                                        '</a>' +
                                    '<i class=" text-success hidden-'+children[j].is_public+'" >&nbsp;&nbsp;public</i> ' +
                                    '<i class=" text-info hidden-'+children[j].is_draft+'" >&nbsp;&nbsp;draft</i>' +
                                '</span>';

            if(children_)
            {
                getChildren(html, children[j].children);
            }

            html.content += '</li>';
        }
        html.content += '</ul>';
    }



    $('.tree > ul').attr('role', 'tree').find('ul').attr('role', 'group');
    $('.tree').find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span > i:first-child').attr('title', 'Collapse this branch').on('click', function(e) {
        var children = $(this).closest('li.parent_li').find(' > ul > li');

        if (children.is(':visible')) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').removeClass().addClass('fa fa-plus');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').removeClass().addClass('fa fa-minus');
        }
        e.stopPropagation();
    });


    var treeView = {

    }

});