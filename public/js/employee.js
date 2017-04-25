var employee=angular.module("app",["shared"]);employee.config(["$stateProvider",function(t){t.state("main",{url:"/",views:{"":{templateUrl:"/app/shared/views/main.view.html",controller:"mainViewController as mainVm"},"content-container@main":{templateUrl:"/app/shared/views/content-container.view.html",controller:"homeContentContainerController as vm"},"toolbar@main":{templateUrl:"/app/shared/templates/toolbar.template.html",controller:"homeToolbarController as vm"},"form@main":{templateUrl:"/app/employee/templates/content/task-form.template.html",controller:"taskFormController as vm"},"content@main":{templateUrl:"/app/employee/templates/content/home-content.template.html"}},resolve:{authentication:["MaterialDesign","User","$state",function(t,e,n){return e.get().then(function(t){e.set(t.data)},function(){n.go("page-not-found")})}]}})}]),employee.factory("taskFormService",["$http","MaterialDesign","Task",function(t,e,n){var a={};return a.new={},a.store=function(){return t.post("/task",a.new)},a.update=function(){return t.put("/task/"+a.data.id,a.data)},a.setCurrent=function(t){n.formatData(t),n.current=t},a.set=function(t){a.data=t},a.setNumberofPhotos=function(t){a.numberOfPhotos=t},a.changeNumberOfPhotos=function(t){t.number_of_photos?(a.setNumberofPhotos(t.number_of_photos),t.number_of_photos=null):t.number_of_photos=a.numberOfPhotos},a.init=function(){a.data={},a.new={},a.numberOfPhotos=null},a}]),employee.controller("editTaskDialogController",["MaterialDesign","taskFormService","formService","Account","User",function(t,e,n,a,o){var r=this;r.task=e,r.account=a,r.user=o,r.department=r.user.user.department.name,"Revolve"==r.department&&(r.batchable=!0),r.task.data.number_of_photos&&(r.batch=!0),r.accounts=function(){var t={where:[{column:"department_id",condition:"=",value:r.user.user.department_id}]};r.account.enlist(t).then(function(t){r.account.data=t.data},function(){Helper.error()})},r.cancel=function(){r.task.init(),n.cancel()},r.submit=function(){n.validate(r.taskForm)||(r.busy=!0,r.task.update().then(function(e){r.busy=!1,t.notify("Changes saved."),t.hide(),r.task.init()},function(){r.busy=!1,t.error()}))},r.init=function(){r.accounts()}()}]),employee.controller("homeContentContainerController",["MaterialDesign","toolbarService","Task","taskFormService","User",function(t,e,n,a,o){var r=this;r.toolbar=e,r.task=n,r.user=o,r.setCurrent=function(t){t&&(r.task.formatData(t),t.pauses.length&&(r.paused=!0,angular.forEach(t.pauses,function(t){r.task.formatData(t)})),r.task.current=t)},r.pause=function(){r.task.pause().then(function(e){r.paused=!0,r.setCurrent(e.data),t.notify("Paused")},function(){t.error()})},r.resume=function(){r.task.resume().then(function(e){r.paused=!1,r.setCurrent(e.data),t.notify("Resumed")},function(){t.error()})},r.finish=function(){t.preloader(),r.task.finish().then(function(){t.hide(),t.notify("Task completed."),r.task.current=null,r.task.init(),r.paused=!1},function(){t.error()})},r.edit=function(e){var n={templateUrl:"/app/employee/templates/dialogs/edit-task-dialog.template.html",controller:"editTaskDialogController as vm"};a.set(e),t.customDialog(n).then(function(){r.task.init()})},r.currentTask=function(){var e={relationships:["account"],relationshipsWithConstraints:[{relationship:"pauses",whereNull:["ended_at"],where:[{column:"user_id",condition:"=",value:r.user.user.id}],orderBy:[{column:"created_at",order:"desc"}]}],whereNull:["ended_at"],first:!0};r.task.enlist(e).then(function(t){r.setCurrent(t.data)},function(){t.failed().then(function(){r.currentTask()})})},r.task.query={relationships:["account"],whereNotNull:["ended_at"],where:[{column:"user_id",condition:"=",value:r.user.user.id}],orderBy:[{column:"created_at",order:"desc"}],paginate:20},r.completedTasks=function(){r.task.enlist(r.task.query).then(function(t){r.nextPage=2,r.pagination=t.data,r.task.data=t.data.data,r.show=!0,r.isLoading=!1,r.task.data.length&&angular.forEach(r.task.data,function(t){r.task.formatData(t),r.task.setToolbarItems(t)}),r.loadNextPage=function(){if(r.busy||r.nextPage>r.pagination.last_page)return void(r.isLoading=!1);r.busy=!0,r.isLoading=!0,r.task.paginate(r.task.query,r.nextPage).then(function(t){r.nextPage++,angular.forEach(t.data.data,function(t){r.task.formatData(t),r.task.pushItem(t),r.task.setToolbarItems(t)}),r.busy=!1,r.isLoading=!1},function(){r.loadNextPage()})}},function(){t.failed().then(function(){r.completedTasks()})})},r.task.init=function(){r.show=!1,r.isLoading=!0,r.toolbar.clearItems(),r.currentTask(),r.completedTasks()},r.task.init()}]),employee.controller("taskFormController",["MaterialDesign","taskFormService","formService","User","Account",function(t,e,n,a,o){var r=this;r.task=e,r.account=o,r.user=a,r.department=r.user.user.department.name,r.task.new.revision=!1,"Revolve"==r.department&&(r.batchable=!0),r.accounts=function(){var t={where:[{column:"department_id",condition:"=",value:r.user.user.department_id}]};r.account.enlist(t).then(function(t){r.account.data=t.data},function(){Helper.failed().then(function(){r.accounts()})})},r.submit=function(){n.validate(r.form)||(r.busy=!0,r.task.store().then(function(e){r.busy=!1,t.notify("Task created."),r.task.setCurrent(e.data),r.task.init()},function(){r.busy=!1,t.error()}))},r.init=function(){r.accounts()}()}]),employee.controller("homeToolbarController",["MaterialDesign","toolbarService","Task",function(t,e,n){var a=this;a.toolbar=e,a.toolbar.content=n,a.toolbar.parentState=null,a.toolbar.childState="Home",a.toolbar.hideSearchIcon=!1,a.toolbar.searchAll=!0,a.toolbar.options=!0,a.toolbar.showInactive=!1,a.sort=[{label:"Recently added",type:"created_at",sortReverse:!1}]}]);