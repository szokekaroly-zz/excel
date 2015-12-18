var excel;
var settings;

$(document).ready(function () {
    excel = excelFactory(settings);
    $(document).keydown(function (event) {
        switch (event.keyCode) {
            case 9 :
                excel.endEditSelected(excel.nextCol);
                event.preventDefault();
                break;
            case 13:
                excel.endEditSelected(excel.nextRow);
                event.preventDefault();
                break;
            case 27:
                excel.cancelEditSelected();
                break;
            case 37:
                if (!excel.isEditMode()) {
                    excel.prevCol();
                    event.preventDefault();
                }
                break;
            case 38:
                if (!excel.isEditMode()) {
                    excel.prevRow();
                    event.preventDefault();
                }
                break;
            case 39:
                if (!excel.isEditMode()) {
                    excel.nextCol();
                    event.preventDefault();
                }
                break;
            case 40:
                if (!excel.isEditMode()) {
                    excel.nextRow();
                    event.preventDefault();
                }
                break;
        }
    }).keypress(function (event) {
        if (event.charCode && !excel.isEditMode()) {
            excel.editSelected(event.key);
        }
    });
    $('.cell').click(excel.clickCell).
            dblclick(excel.dblClickCell);
    $('.rows').click(excel.selectRow);
    $('.cols').click(excel.selectCol);
    $('#add-col').click(excel.addCol);
    $('#add-row').click(excel.addRow);
    $.post('index.php?home/get_all_cells', function (resp) {
        //console.log(resp);
        try {
            var cells = JSON.parse(resp);
            if (cells.status === 'OK') {
                cells = cells.cells;
                for (var i = 0; i < cells.length; i++) {
                    var selector = '.col_' + cells[i].col + '.row_' + cells[i].row;
                    $(selector).html(cells[i].value);
                    if (!isNaN(cells[i].value) && isFinite(cells[i].value)) {
                        $(selector).addClass('right');
                    } else {
                        $(selector).removeClass('right');
                    }
                }
            } else {
                throw cells.msg;
            }
        } catch (e) {
            console.log(e);
        }
    });
});

function excelFactory(settings) {
    var col = 1;
    var row = 1;
    var isEditMode = false;

    function getEditMode() {
        return isEditMode;
    }

    function nextRow() {
        if (row < settings.maxRow) {
            row += 1;
            selectCell();
        }
    }

    function prevRow() {
        if (row > 1) {
            row -= 1;
            this.selectCell();
        }
    }

    function nextCol() {
        if (col < settings.maxCol) {
            col += 1;
            selectCell();
        }
    }

    function prevCol() {
        if (col > 1) {
            col -= 1;
            selectCell();
        }
    }

    function setCoord(coord) {
        if (coord && coord.length >= 2) {
            var newRow = parseInt(coord.substr(1));
            var newCol = parseInt(coord.substr(0, 1).charCodeAt(0) - 64);
            if (newRow <= settings.maxRow && newRow >= 1 &&
                    newCol <= settings.maxCol && newCol >= 1) {
                row = newRow;
                col = newCol;
                selectCell();
            }
        }
    }

    function editSelected(text) {
        $('.selected').html('<input type="text" />').focusout(endEditSelected);
        isEditMode = true;
        $('input').focus().val(text);
    }

    function endEditSelected(callback) {
        if (isEditMode) {
            var value = $('input').val();
            var data = {col: col, row: row, value: value};
            $.post('index.php?home/savecell', data, function (resp) {
                console.log(resp);
                try {
                    var cell = JSON.parse(resp);
                    if (cell.status === 'OK') {
                        $('.selected').html(cell.msg);
                        if (!isNaN(cell.msg) && isFinite(cell.msg)) {
                            $('.selected').addClass('right');
                        } else {
                            $('.selected').removeClass('right');
                        }
                    }
                } catch (e) {
                    console.log(e);
                }
                callback();
            });
            $('.selected').html('');
            isEditMode = false;
        }
    }

    function cancelEditelected() {
        if (isEditMode) {
            $('.selected').html('');
            isEditMode = false;
        }
    }

    function removeSelection() {
        $('.select-col').removeClass('select-col');
        $('.select-row').removeClass('select-row');
        $('.selected').removeClass('selected');
        $('#remove-selected').removeClass('enabled').addClass('disabled').off('click');
    }

    function selectCell() {
        removeSelection();
        var coord = '#' + String.fromCharCode(64 + col) + row;
        $(coord).addClass('selected');
    }

    function clickCell(event) {
        setCoord($(this).attr('id'));
    }

    function dblClickCell(event) {
        if (!getEditMode()) {
            setCoord($(this).attr('id'));
            editSelected($(this).text());
        }
    }

    function selectRow() {
        removeSelection();
        row = $(this).html();
        $('.row_' + row).addClass('select-row');
        row = Number(row);
        if (settings.maxCol > 1) {
            $('#remove-selected').removeClass('disabled').addClass('enabled').click(deleteSelectedRow);
        }
    }

    function selectCol() {
        removeSelection();
        col = $(this).attr('class').split(" ")[1];
        col = col.split('_')[1];
        $('.col_' + col).addClass('select-col');
        col = Number(col);
        if (settings.maxCol > 1) {
            $('#remove-selected').removeClass('disabled').addClass('enabled').click(deleteSelectedCol);
        }
    }

    function deleteSelectedCol() {
        removeSelection();
        $.post('index.php?home/del_col', function (resp) {
           console.log(resp); 
            try {
                respObj = JSON.parse(resp);
                if (respObj.status === 'OK') {
                    for (var toCol = col; toCol < settings.maxCol; toCol++) {
                        $('.col_' + toCol).each(function (i, element) {
                            if (i > 0) {
                                var fromCol = toCol + 1;
                                element.innerHTML = $('.col_' + fromCol + '.row_' + i).text();
                            }
                        });
                    }
                    $('.col_' + settings.maxCol).remove();
                    settings.maxCol = + respObj.msg;
                    if (settings.maxCol <= 26) {
                        $('#add-col').removeClass('disbled').addClass('enabled').click(addCol);
                    }
                } else {
                    throw respObj.msg;
                }
            } catch (e) {
                console.log(e);
            }
        });
    }

    function deleteSelectedRow() {
        removeSelection();
        $.post('index.php?home/del_row', function (resp){
            console.log(resp);
            try {
                var respObj = JSON.parse(resp);
                if (respObj.status === 'OK') {
                    settings.maxRow = +respObj.msg;
                    for (var toRow = row; toRow < settings.maxRow + 1; toRow++) {
                        $('.row_' + toRow).each(function (i, element) {
                            if (i > 0) {
                                var fromRow = toRow + 1;
                                element.innerHTML = $('.row_' + fromRow + '.col_' + i).text();
                            }
                        });
                    }
                    $('.row_' + settings.maxRow + 1).parent().remove();
                }
            } catch (e) {
                console.log(e);
            }
        });
    }

    function addCol() {
        removeSelection();
        $.post('index.php?home/add_col', function (resp) {
            console.log(resp);
            try {
                respObj = JSON.parse(resp);
                if (respObj.status === 'OK') {
                    settings.maxCol = + respObj.msg;
                    var colStr = String.fromCharCode(65 + settings.maxCol);
                    $('table tr').each(function (i, element) {
                        if (i === 0) {
                            var th = document.createElement('th');
                            th.innerHTML = colStr;
                            th.className = 'cols col_' + settings.maxCol;
                            th.onclick = selectCol;
                            element.appendChild(th);
                        } else {
                            var td = document.createElement('td');
                            td.id = colStr + i;
                            td.className = 'cell col_' + settings.maxCol + ' row_' + i;
                            td.onclick = clickCell;
                            td.ondblclick = dblClickCell;
                            element.appendChild(td);
                        }
                    });
                    if (settings.maxCol === 26) {
                        $('#add-col').addClass('disabled').off('click');
                    }
                } else {
                    throw respObj.msg;
                }
            } catch (e) {
                console.log(e);
            }
        });
    }

    function addRow() {
        removeSelection();
        $.post('index.php?home/add_row', function (resp) {
            console.log(resp);
            try {
                respObj = JSON.parse(resp);
                if (respObj.status === 'OK') {
                    var td;
                    var tr = document.createElement('tr');
                    settings.maxRow++;
                    for (var i = 0; i <= settings.maxCol; i++) {
                        if (i === 0) {
                            td = document.createElement('td');
                            td.innerHTML = settings.maxRow;
                            td.className = 'rows row_' + settings.maxRow;
                            td.onclick = selectRow;
                            tr.appendChild(td);
                        } else {
                            var colStr = String.fromCharCode(64 + i);
                            td = document.createElement('td');
                            td.id = colStr + i;
                            td.className = 'cell col_' + i + ' row_' + settings.maxRow;
                            td.onclick = clickCell;
                            td.ondblclick = dblClickCell;
                            tr.appendChild(td);
                        }
                    }
                    $('table tr:last').after(tr);
                } else {
                    throw resp.msg;
                }
            } catch (e) {
                console.log(e);
            }
        });
    }

    removeSelection();
    
    return {
        settings: settings,
        isEditMode: getEditMode,
        nextRow: nextRow,
        prevRow: prevRow,
        nextCol: nextCol,
        prevCol: prevCol,
        setCoord: setCoord,
        editSelected: editSelected,
        endEditSelected: endEditSelected,
        cancelEditSelected: cancelEditelected,
        selectCell: selectCell,
        clickCell: clickCell,
        dblClickCell: dblClickCell,
        selectRow: selectRow,
        selectCol: selectCol,
        deleteSelectedCol: deleteSelectedCol,
        deleteSelectedRow: deleteSelectedRow,
        addCol: addCol,
        addRow: addRow
    };
}

