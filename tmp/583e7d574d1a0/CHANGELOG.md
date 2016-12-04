## CHANGELOG

### version: [160715211500] Published date: 2016-07-15
    I. New feature
        SE-75: Add "Display Business Process" action to Detail View action menu
            + Retrieve all cgx workflows from the Casegenix Workflow
            + Add the "Display Business Process" action to the detail view action menu
            + Display a second menu that is displayed when the mouse hovers over "Display Business Process"
            + Display popup & The size of the pop up should automatically size to two thirds of the current browser
        SE-76: Synchronise user information from SuiteCRM to CGX
            + Extension of the Role module in SuiteCRM
                 - Add attribute: "Mapped to Casegenix role" - text field (not mandatory)
            + On user creation in SuiteCRM
                 - Create user with same user id, first and last name, email in CGX
                 - Check whether the same password can be set in CGX
                 - Assign CGX roles to user based on the SuiteCRM Role to CGX Role mappings
            + On user modification in SuiteCRM
                 - Same as above only that the user is not created but the user with the respective user id is updated
                 - If no user with the respective user id is found in CGX then a user is created
            + On user deletion in SuiteCRM
                 - All CGX roles are removed from the respective user
            + On password change
                - Check whether the same password can be set in CGX
            + On Create/Edit of Role in SuiteCRM
                - Check only if the Mapping to CGX role has changed
                - Iterate over all SuiteCRM users that have this role
                - remove the CGX role an assign the new CGX role
        SE-90: Implement basic authentication for CGX web service calls
            SE-91 Extend the Casegenix section in the SuiteCRM administration
               - Implement CGX API authenticate
               - Authenticate form (include js validate)
               - Reused API authen to test connection
            SE-92 Refactor the web services to use basic authentication
    II. Fix bugs:
        + Queue Module: Blank after ',' is missing in queue name list
        + Task Record (for CGX task): problems with viewer, status and completion option
        + Task and Queue Module: Fast Forward does not open the parent record in a new tab
        
### version: [1607081192400] Published date: 2016-07-08
    I. New feature
        1. Trigger SuiteCRM Workflow to init CGX workflow
            + Custom action (Trigger Casegenix Business Process)
            + Remove 'Add Field' &  "Add Relationship" button
            + Store all of Work Area, Case Category, Case Type, Case Subtype, Name to config
            + Get "Workflow Module" to display when "field" was selected
        2. Implement Workflow API
            + Create new record in SuiteCRM and post data to CGX workflow
            + Make sure post the parent (Object) & parent_id (Object ID) to CGX's workflow
            + Store workflow api response to `cgx_workflow` table
    II. Fix bugs:
        1. Bug fixing of batch job
           + Unlink record doesn't linked to CGX (update delete = 1) 
        2. Fix sprint 3 bugs
           + Admin config make confuse (change environment to show debug logger)
           + refactory api
           + SE-94: Non System Administration users cannot access Queue module
                  Module name doesn't showed correctly
           + SE-95: Queue module: 'Relates to' is empty
           + SE-96: Task module: 'Related to' not populated for CGX tasks
           + SE-97: Task and Queue module: change to "Drop Down"
           + SE-98: Standard Task action icons missing
           + SE-99: Queue module: change "Relates to" to "Related to"
           + SE-100: Change module name and description

### version: [160702050250] Published date: 2016-07-02
    I. New feature
        1. Tasks listing view
            + Fast forward feature
            + User assign feature
            + Completion options listing and assignment
            + Do not allow checkbox to select cgx tasks in the listing view (include select all checkbox)

        2. Task detail view
            + Display Business Process
            + Disable Edit, Duplicate and Delete
            + Disable user assignment for CGX
            + Disable Close and Close/Create new menu entries/buttons
            + Add Assignment option menu
            + Add Completion option menu

        3. Queue listing view
            + Display data, column, action for Queue list view
            + Assignment & Completion Action

    II. Fix bugs:
        1. Bug fixing of batch job
        2. Fix sprint 2 bugs

### version: [1566482425] Published date: 2016-06-24
    I. New feature
        1. Tasks listing view
            + Show fields/columns of Task in grid listing view
            + Make sure fields/columns can be configuration in admin (Studio)
            + Add action column to display assignment & completion
            + Self assign, Self Unassign feature
            + Basic search feature to search via Task name in Tasks listing view

        2. Business Processing Context
            + Show business processing context for started task.
            + Show parent name, parent type (URL)
            + Defer action to ON HOLD the task
            + Show popup business process (workflow diagram)

        3. Queue batch job
            + Make cronjob to retrieve data from CGX
            + Create new Tasks/Queue if not exist in SuiteCRM
            + Update permission/status of Tasks/Queue

        4. Admin setting & Configuration
            + Create/Update the Tasks/Queue custom attributes
            + Create admin setting for CGX API URL
    II. Fix bug:
        Fix sprint 1 bugs
