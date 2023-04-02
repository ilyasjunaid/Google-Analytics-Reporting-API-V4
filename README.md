# Google-Analytics-Reporting-API-V4

This code is ready to use. By default it will show data of current month but you can also filter it by selecting the values from Date Range drop down or select start and end dates manually and hit submit button. You just need to follow the steps below to show data of your google analytics property.

1- Download the code and upload it to your hosting.

2- Sign in/ Sign up google cloud platform, Go to APIs & Services section, scroll down to find a list of APIs and select Analytics Reporting Api and enable it.

3- Open the [Service accounts page](https://console.cloud.google.com/iam-admin/serviceaccounts). If prompted, select a project.

4- Click add Create Service Account, enter a name and description for the service account. You can use the default service account ID, or choose a different, unique one. When done click Create.

5- The Service account permissions (optional) section that follows is not required. Click Continue.

6- On the Grant users access to this service account screen, scroll down to the Create key section. Click add Create key.

7- In the side panel that appears, select the format for your key: JSON is recommended.

8- Click Create. Your new public/private key pair is generated and downloaded to your machine; it serves as the only copy of this key. For information on how to store it securely, see Managing service account keys.

9- Click Close on the Private key saved to your computer dialog, then click Done to return to the table of your service accounts.

10- Add downloaded json file to the root directory. And replace the name of the file with this string "name-of-the-json-file" in the code.

11- Add email address of the newly created Service account to the Account Access Management under google analytics with View permissions to access the report. The email address will look like "analytics@PROJECT-ID.iam.gserviceaccount.com".

12- Get view id in view settings of your google analytics property and assign it to the variable $ViewID in the code.

13- Client library is already installed. But if you want to do it by yourself, do it using composer in the root directory

### `composer require google/apiclient:^2.0`