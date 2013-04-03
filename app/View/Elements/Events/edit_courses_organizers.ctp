<script type="text/javascript">
var availableRoles = [];

// Load up data from the server
$.getJSON('/roles/index.json', function(data) {
    for(var i = 0; i < data.length; i++) {
        var availableRole = {};
        availableRole.id = data[i].id;
        availableRole.name = data[i].name;
        availableRoles.push(availableRole);
    }

    $(document).ready(function(){
        finishLoadingOrganizers();
    });
});

var roleById = function(id) {
    for(var i = 0; i < availableRoles.length; i++) {
        if(availableRoles[i].id == id) {
            return availableRoles[i];
        }
    }
}

var finishLoadingOrganizers = function() {
    var Course = function(id, name, distance, climb, isScoreO, description) {
        this.id = id;
        this.name = ko.observable(name);
        this.distance = ko.observable(distance);
        this.climb = ko.observable(climb);
        this.isScoreO = ko.observable(isScoreO);
        this.description = ko.observable(description);
        this.remove = function() {
            // Only need to confirm for deletion if the course hasn't been created locally
            if(this.id != null) {
                if(confirm("Are you sure you want to delete this course? This will also delete any results associated to the course.")) {
                    $.ajax('/courses/delete/' + this.id);
                    viewModel.courses.remove(this);
                }
            } else {
                viewModel.courses.remove(this);
            }
        }
    }
        
    var Organizer = function(id, name, roleId) {
        this.id = id;
        this.name = ko.observable(name);
        this.availableRoles = ko.observableArray(availableRoles);
        this.role = ko.observable(roleById(roleId));
        this.remove = function() {
            viewModel.organizers.remove(this);
        }
    }
    var viewModel = {
        organizers: ko.observableArray([]),
        addOrganizer: function(id, name, roleId) {
            this.organizers.push(new Organizer(id, name, roleId));
        },
        courses: ko.observableArray([]),
        addCourse: function(id, name, distance, climb, isScoreO, description) {
            this.courses.push(new Course(id, name, distance, climb, isScoreO, description));   
        },
        addNewCourse: function() {
            this.courses.push(new Course(null, null, null, null, false, null));
        }
    }

    var organizerJson = $("#EventOrganizers").val();
    var originalOrganizers = JSON.parse(organizerJson);
    for(var i = 0; i < originalOrganizers.length; i++) {
        var originalOrganizer = originalOrganizers[i];
        viewModel.addOrganizer(originalOrganizer["id"], originalOrganizer["name"], originalOrganizer["role"]["id"]);
    }
        
    var courseJson = $("#EventCourses").val();
    var originalCourses = JSON.parse(courseJson);
    for(var i = 0; i < originalCourses.length; i++) {
        var originalCourse = originalCourses[i];
        viewModel.addCourse(originalCourse["id"], originalCourse["name"], originalCourse["distance"], originalCourse["climb"], originalCourse['isScoreO'],  originalCourse["description"]);
    }
    $(function() {
        orienteerAppPersonPicker('#organizers', { maintainInput: false }, function(person) {
            if(person != null) {
                $('#organizers').val(null);
                viewModel.addOrganizer(person.id, person.name);
            }
        });
    });
    ko.applyBindings(viewModel);
}
</script>
<div id='edit-organizers'>
    <script type="text/html" id="organizerTemplate">
    <tr>
        <td data-bind="text: name || 'Anonymous'"></td>
        <td>
            <select class="thin-control" data-bind="options: availableRoles, value: role, optionsText: 'name'">
            </select>
        </td>
        <td>
            <button type="submit" class="btn btn-mini btn-danger pull-right" data-bind="click: remove"><i class="icon-trash icon-white"></i></button>
        </td>
    </tr>
    </script>
    <fieldset class="control-group">
        <label for="organizers" class="control-label">Event Organizers</label>
        <div class="controls">
            <input placeholder="Add an organizer" type="text" id="organizers" />
            <br/><br/>
            
            <table class="table table-striped table-condensed" data-bind="visible: organizers().length > 0">
                <thead><tr><th>Name</th><th>Role</th><th></th></tr></thead>
                <tbody data-bind="template: {name:'organizerTemplate', foreach: organizers}"></tbody>
            </table>
        </div>
    </fieldset>
</div>

<div id='edit-courses'>
    <script type="text/html" id="courseTemplate">
    <tr>
        <td class="span2"><input type="text" class="span2 thin-control" data-validate = "validate(required)" data-bind="value: name, uniqueName: true" required /></td>
        <td class="span1"><input class="span1 thin-control" type="number" data-bind="value: distance" /></td>
        <td class="span1"><input class="span1 thin-control" type="number" data-bind="value: climb" /></td>
        <td class="span1"><input class="span1 thin-control" type="checkbox" data-bind="checked: isScoreO" /></td>
        <td><input type="text" class="thin-control spanning-control" data-bind="value: description" /></td>
        <td>
            <button type="submit" class="btn btn-mini btn-danger pull-right" data-bind="click: remove"><i class="icon-trash icon-white"></i></button>
        </td>
    </tr>
    </script>
    <fieldset class="control-group">
        <label class="control-label">Courses</label>
        <div class="controls">
            <button type="submit" class="btn btn-success" data-bind="click: addNewCourse">
                <i class="icon-plus icon-white"></i> Course
            </button>
            <br/><br/>
            <table class="table table-striped table-condensed" data-bind="visible: courses().length > 0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Dist. (m)</th>
                        <th>Climb (m)</th>
                        <th>Point Scoring</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody data-bind="template: {name:'courseTemplate', foreach: courses}"></tbody>
            </table>
        </div>
    </fieldset>
</div>

