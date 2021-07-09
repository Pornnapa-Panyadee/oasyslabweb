$(()=>{
    //Member
    $("#position-add").submit(function (event) {
        var name_th = $('input[name="position_th"]').val()
        var name_en = $('input[name="position_en"]').val()
        var priority_pos = $('input[name="priority_pos"]').val()
        var _token = $('input[name="_token"]').val()
        if ((name_th == undefined || name_th == "") || (name_en == undefined || name_en == "") || (priority_pos == undefined || priority_pos == "")){
            alert('please fields all data.')
        }else{
            $.ajax({
                url: window.location.origin + "/backend/members/add-position",
                method: "POST",
                data: {
                    'name_th' : name_th,
                    'name_en' : name_en,
                    'priority': priority_pos,
                    '_token' : _token
                }
            }).done(function (data) {
                $('input[name="position_th"]').val('')
                $('input[name="position_en"]').val('')
                $('input[name="priority_pos"]').val('')
                if (data.status == 'success'){
                    var html = ''
                    data.message.map((position)=>{
                        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>${position.name_th} / ${position.name_en}</div>
                        <div class="float-right"><div class="d-inline-flex">
                        <button class="btn btn-outline-danger btn-sm" onclick="deletePosition(${position.id})">Delete</button>
                        </div></div></li>`
                    })
                    $("#position-list").html(html)
                }else{
                    alert(data.message)
                }
            }).fail(function (response) {
                alert(response.statusText)
            })
        }
        event.preventDefault();
    });

    $("#fields-add").submit(function (event) {
        var name = $('input[name="field_name"]').val()
        var _token = $('input[name="_token"]').val()
        if (name == undefined || name == "") {
            alert('please fields all data.')
        } else {
            $.ajax({
                url: window.location.origin + "/backend/members/add-field",
                method: "POST",
                data: {
                    'name': name,
                    '_token': _token
                }
            }).done(function (data) {
                $('input[name="field_name"]').val('')
                if (data.status == 'success') {
                    var html = ''
                    data.message.map((field) => {
                        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>${field.name}</div>
                        <div class="float-right"><div class="d-inline-flex">
                        <button onclick="editField(${field.id},'${field.name}')" class="btn btn-outline-secondary btn-sm mr-1" data-toggle="modal" data-target="#editFields">Edit</button>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteField(${field.id})">Delete</button>
                        </li>`
                    })
                    $("#field-list").html(html)
                } else {
                    alert(data.message)
                }
            }).fail(function (response) {
                alert(response.statusText)
            })
        }
        event.preventDefault();
    });

    $("#fields_select").change(function () {
        var addFieldsId = tempFields.find(function(field){
            if (field.id == $("#fields_select").val()){
                return field
            }
        })
        tempId.push(addFieldsId.id)
        tempSelectFieldList.push(addFieldsId)
        tempFields = tempFields.filter(function (element) {
            return element !== addFieldsId
        })
        htmlSelect = ''
        htmlSelect += `<option value="">Select Fields</option>`
        tempFields.forEach(function (row) {
            htmlSelect += `<option value="${row.id}">${row.name}</option>`
        })
        $('#fields_select').html(htmlSelect)
        $('#fieldsInterest').append(`<label class="tag d-inline mt-2" id="fieldsform${addFieldsId.id}">${addFieldsId.name}<span aria-hidden="true" onclick="deleteFieldInForm(${addFieldsId.id})">&times;</span></label>`)
        $('input[name="field_interest"]').val(tempId)
    })

    setTimeout(() => {
        if (memberFields != undefined){
            var html = ''
            memberFields.map(function(row){
                html += `<label class="tag d-inline mt-2" id="fieldsform${row.field_interest.id}">${row.field_interest.name}<span aria-hidden="true" onclick="deleteFieldInForm(${row.field_interest.id})">&times;</span></label>`
                tempId.push(row.field_interest.id)
                tempFields = tempFields.filter(function (element) {
                    return element.id !== row.field_interest.id
                })
            })
            htmlSelect = ''
            htmlSelect += `<option value="">Select Fields</option>`
            tempFields.forEach(function (row) {
                htmlSelect += `<option value="${row.id}">${row.name}</option>`
            })
            $('#fields_select').html(htmlSelect)
            $('#fieldsInterest').html(html)
            $('input[name="field_interest"]').val(tempId)
        }
    }, 1000);

    //image
    $('#image-search').click(function(){
        var word = $('input[name="search"]').val()
        var html = ''
        tempImageList.filter((image) => {
            return image.name.toLowerCase().indexOf(word.toLowerCase()) > -1
        }).map((image) => {
            html += `<div class="col-6 col-md-4 mb-3">
                        <a href="javascript:chooseImage(${image.id})">
                            <div class="image-wrapper" id="img${image.id}">
                                <img class="w-100" src="${window.location.origin}/${image.path}" alt="">
                                    <p class="text-center mb-0">${image.name}</p>
                                </div>
                            </a>
                        </div>`
        })
        $("#images-list").html(html)
    })

    $('#image-search-page').click(function () {
        console.log('test')
        var word = $('input[name="search"]').val()
        var html = ''
        tempImageList = allImages
        tempImageList.filter((image) => {
            return image.name.toLowerCase().indexOf(word.toLowerCase()) > -1
        }).map((image) => {
            html += `<div class="col-6 col-md-4 mb-3">
                        <div class="image-wrapper shadow-sm">
                            <img class="w-100" src="${window.location.origin}/${image.path}" alt="">
                            <p class="text-center mb-0 pt-2">${image.name}</p>
                        </div>
                    </div>`
        })
        $("#images-list-page").html(html)
    })

    $('#imagefile').bind('change', function () {
        if (this.files[0].size / 1024 / 1024 > 2.5){
            alert('Maximum File Size You Can Upload Should Less Than 2.6MB')
            $('#imagefile').val('')
        }else{
            $('#uploadImageBtn').removeAttr('disabled')
        }
    });

    $("#uploadImage").submit(function (event) {
        var file = $('input[name="file"]').val()
        var id = $('input[name="file_name"]').val()
        if (file == undefined || file == "") {
            $('#fileHelp').show()
            event.preventDefault();
        }
        if (id == undefined || id == "") {
            $('#nameImage').show()
            event.preventDefault();
        }
    });

    //publication
    $("#total_members").change(function () {
        if ($('#total_members').val() != '' || $('#total_members').val() != undefined){
            var num = $('#total_members').val()
            html = ''
            for (let index = 1; index <= num; index++) {
                html += `<div class="form-group row"><label for="no1" class="col-sm-3 col-form-label">Author order. ${index}</label>
                            <input type="hidden" class="form-control" name="no${index}">
                            <div class="col-sm-9"><select class="form-control" id="member_id_${index}" name="member_id_${index}"></select></div></div>`
            }
            $('#order_author_list').html(html)
            setTimeout(() => {
                html = ''
                for (let index = 1; index <= num; index++) {
                    html = '<option value = "">Select Member</option>'
                    members.map(function (member) {
                        html += `<option value="${member.id}">${member.en_name}</option>`
                    })
                    $(`#member_id_${index}`).html(html)
                }
            }, 1000);
        }
    })
})

var submitEditFields = ()=>{
    var name = $('input[name="field_name_edit"]').val()
    var id = $('input[name="field_id_edit"]').val()
    var _token = $('input[name="_token"]').val()
    if (name == undefined || name == "") {
        alert('please fields all data.')
    } else {
        $.ajax({
            url: window.location.origin + "/backend/members/edit-field/" + id,
            method: "PUT",
            data: {
                'name': name,
                '_token': _token
            }
        }).done(function (data) {
            $('input[name="field_name_edit"]').val('')
            if (data.status == 'success') {
                var html = ''
                data.message.map((field) => {
                    html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>${field.name}</div>
                        <div class="float-right"><div class="d-inline-flex">
                        <button onclick="editField(${field.id},'${field.name}')" class="btn btn-outline-secondary btn-sm mr-1" data-toggle="modal" data-target="#editFields">Edit</button>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteField(${field.id})">Delete</button>
                        </li>`
                })
                $("#field-list").html(html)
            } else {
                alert(data.message)
            }
        }).fail(function (response) {
            alert(response.statusText)
        })
    }
};

//Member
var fields
var memberFields
if (fields != undefined) {
    var tempFields = fields;
}
var tempSelectFieldList = [];
var tempId = [];
var deletePosition = (id) => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + "/backend/members/delete-position/" + id,
        method: "DELETE"
    }).done(function (data) {
        if (data.status == 'success') {
            var html = ''
            data.message.map((position) => {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>${position.name_th} / ${position.name_en}</div>
                        <div class="float-right"><div class="d-inline-flex">
                        <button class="btn btn-outline-danger btn-sm" onclick="deletePosition(${position.id})">Delete</button>
                        </div></div></li>`
            })
            $("#position-list").html(html)
        } else {
            alert(data.message)
        }
    }).fail(function (response) {
        alert(response.statusText)
    })
}

var deleteField = (id) => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + "/backend/members/delete-field/" + id,
        method: "DELETE"
    }).done(function (data) {
        if (data.status == 'success') {
            var html = ''
            data.message.map((field) => {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>${field.name}</div>
                        <div class="float-right"><div class="d-inline-flex">
                        <button onclick="editField(${field.id},'${field.name}')" class="btn btn-outline-secondary btn-sm mr-1" data-toggle="modal" data-target="#editFields">Edit</button>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteField(${field.id})">Delete</button>
                        </div></div></li>`
            })
            $("#field-list").html(html)
        } else {
            alert(data.message)
        }
    }).fail(function (response) {
        alert(response.statusText)
    })
}

var prepareDeleteMemberBtn = (id) => {
    $('#deleteMemberBtn').attr('onclick', `deleteMember(${id})`)
}

var deleteMember = (id) => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + "/backend/members/delete/" + id,
        method: "DELETE"
    }).done(function (data) {
        if (data.status == 'success') {
            var html = ''
            data.message.map((member) => {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center"><div class="row">
                                <div class="col-4" style="max-width:200px;">
                                    <img class="w-100" src="${window.location.origin}/${member.images.path}" alt="">
                                </div>
                                <div class="col-8">
                                    ${member.th_name} (${member.en_name}) <br>
                                    <p class="pt-3 mb-0"><strong>Position:</strong> ${member.positions.name_en}</p>
                                    <p><strong>Education Level:</strong> ${member.levels.name_en}</p>
                                </div>
                                <div class="col-12 text-right">
                                    <div class="d-inline-flex">
                                        <a href="${window.location.origin}/backend/members/edit/${member.id}" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteMember(${member.id})">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </li>`
            })
            $("#member-list").html(html)
        } else {
            alert(data.message)
        }
    }).fail(function (response) {
        alert(response.statusText)
    })
}

var editField = (id,name) => {
    $('input[name="field_name_edit"]').val(name)
    $('input[name="field_id_edit"]').val(id)
}

var interestFieldsfilter = (id) =>{
    var html = ''
    members.map((member) => {
        if (id == -1) {
            html += `<li class="list-group-item d-flex justify-content-between align-items-center"><div class="row">
                    <div class="col-4" style="max-width:200px;">
                        <img class="w-100" src="${window.location.origin}/${member.images.path}" alt="">
                    </div>
                    <div class="col-8">
                        ${member.th_name} (${member.en_name}) <br>
                        <p class="pt-3 mb-0"><strong>Position:</strong> ${member.positions.name_en}</p>
                        <p><strong>Education Level:</strong> ${member.levels.name_en}</p>
                    </div>
                    <div class="col-12 text-right">
                        <div class="d-inline-flex">
                            <a href="${window.location.origin}/backend/members/edit/${member.id}" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteMember(${member.id})">Delete</button>
                        </div>
                    </div>
                </div>
            </li>`
        }else{
            member.field.find(function(row){
                if(row.id == id){
                    html += `<li class="list-group-item d-flex justify-content-between align-items-center"><div class="row">
                                <div class="col-4" style="max-width:200px;">
                                    <img class="w-100" src="${window.location.origin}/${member.images.path}" alt="">
                                </div>
                                <div class="col-8">
                                    ${member.th_name} (${member.en_name}) <br>
                                    <p class="pt-3 mb-0"><strong>Position:</strong> ${member.positions.name_en}</p>
                                    <p><strong>Education Level:</strong> ${member.levels.name_en}</p>
                                </div>
                                <div class="col-12 text-right">
                                    <div class="d-inline-flex">
                                        <a href="${window.location.origin}/backend/members/edit/${member.id}" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteMember(${member.id})">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </li>`
                }
            })
        }
    })
    $("#member-list").html(html)
}

var deleteFieldInForm = (id) => {
    var field = fields.find(function(element){
        if (element.id == id){
            return element
        }
    })
    tempFields.push(field)
    htmlSelect = ''
    htmlSelect += `<option value="">Select Fields</option>`
    tempFields.forEach(function (row) {
        htmlSelect += `<option value="${row.id}">${row.name}</option>`
    })
    $('#fields_select').html(htmlSelect)
    $(`#fieldsform${id}`).remove()
    tempId = tempId.filter(function (element) {
        return element !== id
    })
    $('input[name="field_interest"]').val(tempId)
}

//banner
var saveBanner = (id) => {
    data = {
        image_id : $(`input[name="image_id${id}"]`).val(),
        external_path: $(`input[name="external_path${id}"]`).val()
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + "/backend/settings/banner/" + id,
        method: "POST",
        data: data
    }).done(function (data) {
        if (data.status == 'success') {
            alert(`success change banner ${id}`)
        } else {
            alert(data.message)
        }
    }).fail(function (response) {
        alert(response.statusText)
    })
}

//detail
var saveDetail = (id) => {
    data = {
        th_name: $(`input[name="th_name${id}"]`).val(),
        en_name: $(`input[name="en_name${id}"]`).val(),
        th_description: $(`textarea[name="th_description${id}"]`).val(),
        en_description: $(`textarea[name="en_description${id}"]`).val(),
        path: $(`input[name="path${id}"]`).val(),
        amount: $(`input[name="amount${id}"]`).val()
    }
    console.log(data)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + "/backend/settings/detail/" + id,
        method: "POST",
        data: data
    }).done(function (data) {
        if (data.status == 'success') {
            console.log(data)
            alert(`Success change data ${id}`)
        } else {
            alert(data.message)
        }
    }).fail(function (response) {
        alert(response.statusText)
    })
}

//image
var tempImageId = ''
var tempImageIdBanner1 = ''
var tempImageIdBanner2 = ''
var tempImageIdBanner3 = ''
var tempImageIdBanner4 = ''
var tempImageIdBanner5 = ''
var tempImageList = [];

var loadImagesBanner = (id) => {
    if ($(`input[name="image_id${id}"]`).val() != undefined) {
        tempImageId = $(`input[name="image_id${id}"]`).val()
    }
    let tempId
    switch (id) {
        case 1:
            tempId = tempImageIdBanner1
            break;
        case 2:
            tempId = tempImageIdBanner2
            break;
        case 3:
            tempId = tempImageIdBanner3
            break;
        case 4:
            tempId = tempImageIdBanner4
            break;
        case 5:
            tempId = tempImageIdBanner5
            break;
        default:
            break;
    }
    $.ajax({
        url: window.location.origin + "/backend/images/ajax",
        method: "GET"
    }).done(function (data) {
        if (data.status == 'success') {
            var html = ''
            tempImageList = data.message
            data.message.map((image) => {
                if ((tempId != '' || tempId != undefined) && tempId == image.id) {
                    html += `<div class="col-6 col-md-4 mb-3">
                                <a href="javascript:chooseImageBanner(${image.id},${id})">
                                    <div class="image-wrapper shadow-sm" id="img${image.id}" style="border:2px solid #2196F3;">
                                        <img class="w-100" src="${window.location.origin}/${image.path}" alt="">
                                        <p class="text-center mb-0">${image.name}</p>
                                    </div>
                                </a>
                            </div>`
                } else {
                    html += `<div class="col-6 col-md-4 mb-3">
                                <a href="javascript:chooseImageBanner(${image.id},${id})">
                                    <div class="image-wrapper" id="img${image.id}">
                                        <img class="w-100" src="${window.location.origin}/${image.path}" alt="">
                                        <p class="text-center mb-0">${image.name}</p>
                                    </div>
                                </a>
                            </div>`
                }
            })
            $("#images-list").html(html)
            $("#bannerChooseBtn").html(`<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-success" data-dismiss="modal" onclick="chooseImageBtnBanner(${id})">Choose</button>`)
        } else {
            alert(data.message)
        }
    }).fail(function (response) {
        alert(response.statusText)
    })
}

var chooseImageBanner = (id, bannerId) => {
    let tempId
    switch (bannerId) {
        case 1:
            tempId = tempImageIdBanner1
            break;
        case 2:
            tempId = tempImageIdBanner2
            break;
        case 3:
            tempId = tempImageIdBanner3
            break;
        case 4:
            tempId = tempImageIdBanner4
            break;
        case 5:
            tempId = tempImageIdBanner5
            break;
        default:
            break;
    }
    if (tempId != '' || tempId != undefined) {
        $(`#img${tempId}`).css("border", '1px solid #d4d4d4')
        $(`#img${tempId}`).removeClass('shadow-sm')
    }
    if (tempId == id) {
        $(`#img${tempId}`).css("border", '1px solid #d4d4d4')
        $(`#img${tempId}`).removeClass('shadow-sm')
        switch (bannerId) {
            case 1:
                tempImageIdBanner1 = ''
                break;
            case 2:
                tempImageIdBanner2 = ''
                break;
            case 3:
                tempImageIdBanner3 = ''
                break;
            case 4:
                tempImageIdBanner4 = ''
                break;
            case 5:
                tempImageIdBanner5 = ''
                break;
            default:
                break;
        }
    } else {
        $(`#img${id}`).css('border-width', '0')
        $(`#img${id}`).css("border", '2px solid #2196F3')
        $(`#img${id}`).addClass('shadow-sm')
        switch (bannerId) {
            case 1:
                tempImageIdBanner1 = id
                break;
            case 2:
                tempImageIdBanner2 = id
                break;
            case 3:
                tempImageIdBanner3 = id
                break;
            case 4:
                tempImageIdBanner4 = id
                break;
            case 5:
                tempImageIdBanner5 = id
                break;
            default:
                break;
        }
    }
}

var chooseImageBtnBanner = (id) => {
    console.log(id)
    let tempId
    switch (id) {
        case 1:
            tempId = tempImageIdBanner1
            break;
        case 2:
            tempId = tempImageIdBanner2
            break;
        case 3:
            tempId = tempImageIdBanner3
            break;
        case 4:
            tempId = tempImageIdBanner4
            break;
        case 5:
            tempId = tempImageIdBanner5
            break;
        default:
            break;
    }
    $(`input[name="image_id${id}"]`).val(tempId)
    var image = tempImageList.find(function (element) {
        if (element.id == tempId) {
            return element
        }
    });
    if (image == undefined) {
        $(`#image-preview${id}`).html('<div class="image-preview-temp"></div>')
    } else {
        $(`#image-preview${id}`).html(`<img class="w-100" src="${window.location.origin}/${image.path}" alt="">`)
    }
}

var loadImages = () => {
    if ($('input[name="image_id"]').val() != undefined) {
        tempImageId = $('input[name="image_id"]').val()
    }
    $.ajax({
        url: window.location.origin + "/backend/images/ajax",
        method: "GET"
    }).done(function (data) {
        if (data.status == 'success') {
            var html = ''
            tempImageList = data.message
            data.message.map((image) => {
                if ((tempImageId != '' || tempImageId != undefined) && tempImageId == image.id) {
                    html += `<div class="col-6 col-md-4 mb-3">
                                <a href="javascript:chooseImage(${image.id})">
                                    <div class="image-wrapper shadow-sm" id="img${image.id}" style="border:2px solid #2196F3;">
                                        <img class="w-100" src="${window.location.origin}/${image.path}" alt="">
                                        <p class="text-center mb-0">${image.name}</p>
                                    </div>
                                </a>
                            </div>`
                } else {
                    html += `<div class="col-6 col-md-4 mb-3">
                                <a href="javascript:chooseImage(${image.id})">
                                    <div class="image-wrapper" id="img${image.id}">
                                        <img class="w-100" src="${window.location.origin}/${image.path}" alt="">
                                        <p class="text-center mb-0">${image.name}</p>
                                    </div>
                                </a>
                            </div>`
                }
            })
            $("#images-list").html(html)
        } else {
            alert(data.message)
        }
    }).fail(function (response) {
        alert(response.statusText)
    })
}

var chooseImage = (id) => {
    if (tempImageId != '' || tempImageId != undefined) {
        $(`#img${tempImageId}`).css("border", '1px solid #d4d4d4')
        $(`#img${tempImageId}`).removeClass('shadow-sm')
    }
    if (tempImageId == id) {
        $(`#img${tempImageId}`).css("border", '1px solid #d4d4d4')
        $(`#img${tempImageId}`).removeClass('shadow-sm')
        tempImageId = ''
    } else {
        $(`#img${id}`).css('border-width', '0')
        $(`#img${id}`).css("border", '2px solid #2196F3')
        $(`#img${id}`).addClass('shadow-sm')
        tempImageId = id
    }
}

var chooseImageBtn = () => {
    $('input[name="image_id"]').val(tempImageId)
    var image = tempImageList.find(function (element) {
        if (element.id == tempImageId){
            return element
        }
    });
    if (image == undefined){
        $('#image-preview').html('<div class="image-preview-temp"></div>')
    }else{
        $('#image-preview').html(`<img class="w-100" src="${window.location.origin}/${image.path}" alt="">`)
    }
}

//projects
var tempProjectId = ''
var showSubProjectPanel = (id) => {
    if (tempProjectId != '' || tempProjectId != undefined) {
        $(`.project${tempProjectId}`).css("border", '1px solid rgba(0,0,0,.125)')
    }
    $(`.project${id}`).css('border', '2px solid #2196F3')
    tempProjectId = id
    $('#create-sub-project-btn').html(`<a href="${window.location.origin}/backend/projects/create-sub-project/${id}" class="btn btn-outline-info btn-sm">Create Sub Projects</a>`)
    $.ajax({
        url: window.location.origin + "/backend/projects/sub-project/" + id,
        method: "GET"
    }).done(function (data) {
        if (data.status == 'success') {
            var html = ''
            if (data.message.length == 0){
                html = '<p class="text-center">No sub-projects.</p>'
            }else{
                data.message.map((subproject) => {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="row"><div class="col-12 col-md-4 mb-3 mb-md-0" style="max-width:200px;"><img class="w-100" src="${window.location.origin}/${subproject.images.path}" alt=""></div>
                            <div class="col-12 col-md-8">
                                ${subproject.th_name} (${subproject.en_name})
                                    <p class="pt-0 mb-0">${subproject.th_description.slice(0, 100) + (subproject.th_description.length > 100 ? "..." : "")}</p>
                                    <p class="pb-2 mb-0">${subproject.en_description.slice(0, 100) + (subproject.en_description.length > 100 ? "..." : "")}</p>
                                    </div>
                                <div class="col-12 text-right">
                                    <div class="d-inline-flex">
                                        <a href="${window.location.origin}/backend/projects/edit-sub-project/${subproject.id}" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteConfirm" onclick="prepareDeleteSubProjectBtn(${subproject.id})">Delete</button>
                                    </div>
                                </div>
                            </div>
                            </li>`
                })
            }
            $("#sub-project-list").html(html)
        } else {
            alert(data.message)
        }
    }).fail(function (response) {
        alert(response.statusText)
    })
}

var deleteSubProject = (id) => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + "/backend/projects/delete-sub/" + id,
        method: "DELETE"
    }).done(function (data) {
        if (data.status == 'success') {
            var html = ''
            if (data.message.length == 0) {
                html = '<p class="text-center">No sub-projects.</p>'
            } else {
                data.message.map((subproject) => {
                    html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="row"><div class="col-4" style="max-width:200px;"><img class="w-100" src="${window.location.origin}/${subproject.images.path}" alt=""></div>
                            <div class="col-8">
                                ${subproject.th_name} (${subproject.en_name}) <br>

                                    <p class="pt-3">${subproject.th_description}</p>
                                    <p class="pb-2 mb-0">${subproject.en_description}</p>
                                    </div>
                                <div class="col-12 text-right">
                                    <div class="d-inline-flex">
                                        <a href="${window.location.origin}/backend/projects/edit-sub-project/${subproject.id}" class="btn btn-outline-secondary btn-sm mr-1">Edit</a>
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteConfirm" onclick="prepareDeleteSubProjectBtn(${subproject.id})">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </li>`
                })
            }
            $("#sub-project-list").html(html)
        } else {
            alert(data.message)
        }
    }).fail(function (response) {
        alert(response.statusText)
    })
}

var prepareDeleteSubProjectBtn = (id) => {
    $('#deleteSubProjectBtn').attr('onclick', `deleteSubProject(${id})`)
}

//publication
var addPublication = () => {
    var type_id = $('select[name="type_id"]').val()
    var detail = $('textarea[name="detail"]').val()
    var total_members = $('input[name="total_members"]').val()
    var _token = $('input[name="_token"]').val()
    var is_done = true
    if (type_id == undefined || type_id == "") {
        $('#type_text').show()
        is_done = false
    }
    if (detail == undefined || detail == "") {
        $('#detail_text').show()
        is_done = false
    }
    if (total_members == undefined || total_members == "") {
        $('#total_text').show()
        is_done = false
    }
    if(is_done){
        let data = {
            'type_id': type_id,
            'detail': detail,
            'total_members': total_members,
            '_token': _token
        }
        let member = []
        for (let index = 1; index <= total_members; index++) {
            temp = {
                'order_id': index,
                'member_id': $(`#member_id_${index}`).val()
            }
            member.push(temp)
        }
        data.members = member
        $.ajax({
            url: window.location.origin + "/backend/publications/create",
            method: "POST",
            data: data
        }).done(function (data) {
            if (data.status == 'success') {
                window.location.href = window.location.origin + "/backend/publications"
            } else {
                alert(data.message)
            }
        }).fail(function (response) {
            alert(response.statusText)
        })
    }
};

var editPublication = (id) => {
    var type_id = $('select[name="type_id"]').val()
    var detail = $('textarea[name="detail"]').val()
    var total_members = $('input[name="total_members"]').val()
    var _token = $('input[name="_token"]').val()
    var id = $('input[name="id"]').val()
    var is_done = true
    if (type_id == undefined || type_id == "") {
        $('#type_text').show()
        is_done = false
    }
    if (detail == undefined || detail == "") {
        $('#detail_text').show()
        is_done = false
    }
    if (total_members == undefined || total_members == "") {
        $('#total_text').show()
        is_done = false
    }
    if (is_done) {
        let data = {
            'type_id': type_id,
            'detail': detail,
            'total_members': total_members,
            '_token': _token
        }
        let member = []
        for (let index = 1; index <= total_members; index++) {
            temp = {
                'order_id': index,
                'member_id': $(`#member_id_${index}`).val()
            }
            member.push(temp)
        }
        data.members = member
        $.ajax({
            url: window.location.origin + "/backend/publications/edit/" + id,
            method: "POST",
            data: data
        }).done(function (data) {
            if (data.status == 'success') {
                window.location.href = window.location.origin + "/backend/publications"
            } else {
                alert(data.message)
            }
        }).fail(function (response) {
            alert(response.statusText)
        })
    }
};

var prepareDeletePublicationBtn = (id)=>{
    $('#deletePublicationBtn').attr('onclick',`deletePublication(${id})`)
}

var deletePublication = (id) => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + "/backend/publications/delete/" + id,
        method: "DELETE"
    }).done(function (data) {
        if (data.status == 'success') {
            window.location.href = window.location.origin + "/backend/publications"
        } else {
            alert(data.message)
        }
    }).fail(function (response) {
        alert(response.statusText)
    })
}

//articles
var prepareDeleteArticleBtn = (id) => {
    $('#deleteArticleBtn').attr('onclick', `deleteArticle(${id})`)
}

var deleteArticle = (id) => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: window.location.origin + "/backend/article/delete/" + id,
        method: "DELETE"
    }).done(function (data) {
        if (data.status == 'success') {
            window.location.href = window.location.origin + "/backend/article"
        } else {
            alert(data.message)
        }
    }).fail(function (response) {
        alert(response.statusText)
    })
}
