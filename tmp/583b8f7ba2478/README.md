# com.genix.suitecrm.casegenix.workflowconnector

### What's in this repository ###
CGX Workflow Connector module

### Requirements

* Apache2.2 or higher. 
    - Recomment 2.4
    - mod_rewrite enabled
* PHP needs to be a minimum version of PHP 5.5 
    - Recomment 5.6.x or higher
    - JSON needs to be enabled
    - ctype needs to be enabled
    - curl needs to be enabled
    - Your php.ini needs to have the date.timezone setting
* Mysql 5.1 or higher. 
    - Recomment 5.5
* SuiteCRM 7.6.x or higher.

### Deployment guide
```bash
   cd path/to/suitecrm
```

```bash
   git clone com.genix.suitecrm.casegenix.workflowconnector.git ./casegenix
```

```bash
   git checkout release[vxx] ([vxx] is the release version eg: v1.0)
```

```bash
   git pull
```


The directory look like:
>   /var/www/html/suitecrm

            |- casegenix
                |- Extension
                |- Release
                    |- CGX[year]_[month]_[day]_[time].zip
                    |- CGX2016_06_14_063004.zip
                    |- deploy.sh
                |- SugarModules
                |- icons              

 ```bash
cp casegenix/Release/deploy.sh ./
```
                                           
The default config was setup for that structure above
If the structure do not like that.

Please copy path-repository/Release/deploy.sh to SuiteCRM/ source

open SuiteCRM/deploy.sh which was copy above

please find and change config arround line 4: 

- $upgrade_dir = "./casegenix/Release/";

That is path of package will using to deploy


####Step 1: create new schedule for Queue batch job.
This action will take cron job to get all Queue from CGX API and store that one to SuiteCRM.
    - Go to: http://your-domain.com/index.php?module=Administration&action=index
    - Select Scheduler in the adminitrator board to go to Schedule listing (http://cgx-crm.local/index.php?module=Schedulers&action=index)
    - Click to button "Create" to create new a scheduler
    - input the "job name" and select "job" to "Queue List refresh batch job"
    - Set "interval" scheduler time.
####Step 2: After that we should create new account which exist in the CGX. Because in this phase we doesn't implement all feature about user yet. So, that manual create account are importance for us  now.
     - Go to: http://your-domain.com/index.php?module=Administration&action=index
     - Select "User Management" in the Administrator board to go to Users listing (http://cgx-crm.local/index.php?module=Users&action=index)
     - Click to button "Create" to create a new user
     - Input the "User Name". For example: "hdwebsoft"
     - Input the another required field such as "Last name", "Email"
     - Click to "Save" button to create new user
####Step 3: Waiting cron job run. The time to waiting in the scheduler which was created in "Step 1"
     For faster to test: Connect to server and run cronjob manually
         $> ssh root@http://casegenix-qa.genixventures.com
         $> cd /var/www/html/suitecrm
         $/var/www/html/suitecrm>php -f cron.php

####Step 4: Verify data:
    Go to Queue module & Tasks. The new data from CGX will append to the listing.


### For developer
```bash
   cd path/to/suitecrm
```

```bash
   git clone com.genix.suitecrm.casegenix.workflowconnector.git ./casegenix
```

```bash
   git checkout develop
```

```bash
   git pull
```

```bash
   git checkout -b feature/SE-xx  (SE-xx is jira ID of the feature)
```

#### Cleanup CGX data in SuiteCRM

Login to MySQL and run 3 queries bellow

```sql
TRUNCATE TABLE `cgx_queue`;
```

```sql
TRUNCATE TABLE `tasks`;
```

```sql
TRUNCATE TABLE `tasks_cstm`;
```

```sql
TRUNCATE TABLE `cases`;
```


### Implement CGX API
All of CGX_API was implemented in module CGX_API/api/CGX_Kit.php

*How to test CGX API?*

The dummy was implement in the CGX_API/controller.php

Please run the url http://domain.local/index.php?module=CGX_API&action=[TestAction]

Change the [TestAction] to api want to test
