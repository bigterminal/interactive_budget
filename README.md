Interactive Canadian Budget
===========================

For the average or even sophisticated Canadian understanding and exploring the Federal Budget is a daunting task. Canadians are expected to be informed about the budget and understand the proposed increases and cuts along with government revenues and the deficit. Without this knowledge Canadians can not effectively communicate with their government and can not make informed voting decisions effectively stifling democracy on this critical subject. This is why we are creating the Interactive Budget to help inform and engage citizens about the budget and how our country spends its roughly $250 billion.

The Goal
--------

The goal for the interactive budget is to create an engaging and elegant visualization of the annual budget that a user can explore at different levels of detail and complexity. At its most basic the budget helps people visually understand how much is spent and what sectors make up the bulk of the budget. More inquisitive users can dive in and get information on specific programs, their cost and how funding has changed over the last few years. It&#39;s worth noting that while all of the data has been provided via the Government's open data program we have high expectations for them to release a great deal more along with providing better tools for access and use.

Future Updates
--------------

While the current version does a great job of giving you an overview of the budget we have many ideas of how to provide greater depth and more interesting layouts. We are currently developing many more sections that will be released in the months to come.

1. <b>Federal Income</b><br>
Our plan is to create a comprehensive chart detailing government revenue sources with interesting demographic information. For example we would show Corporate Income Tax along with a breakdown of the top 100 corporations contributing.

2. <b>Spending/Income Map</b><br>
We plan to create an interactive map of Canada using a Choropleth chart that shows annual spending and income per district. This will help Canadians understand what districts generate and spend the most money and provide a clear understanding of what areas are net positive or negative.

3. <b>Create Your own Budget</b><br>
An ambitious feature idea we have is to allow users to modify the budget and income plans for Canada and share it with other users. This truly interactive budget tool would provide Canadians with a clear understanding of the trade offs the government makes and the outcomes of a tax increase. We hope it will provide perspective to citizens and create a dialogue around new ideas. Additionally we believe it can be a powerful tool for news outlets and other pundits to create their own budgets alongside editorial. Finally  we believe it will allow any candidate to create and share their budget plans during a campaign helping citizens clearly understand their platform and how to vote, alongside providing greater accountability.

4. <b>Worldwide Data</b><br>
Another ambitious tool we plan is to add in the data from other major economies around the world. With this users in those countries can better understand their federal income and spending much the same as Canadians. Such a feature would also allow comparison between nations and we could begin to graph outcomes alongside spending. For example we could compare the health care spending of Australia and Canada alongside healthcare quality metrics.

5. <b>Real Time Budget</b><br>
The last feature we hope to create is a real time budget graph that shows the current annual budget alongside real time spending. In this way citizens can monitor the spending in programs and understand where overspending or changes are happening. This real time tool would be useful not only to citizens but to business and government representatives.

Setup
-----

* <i>Should work with most LAMP stacks</i>
* Clone repo into working directory
* Set DocumentRoot to public/
* Import ~/db/structure.sql into MySQL
* Copy private/template.config.php to private/config.php
* Populate required configuration properties
* Create directory private/templates/cache
* Ensure webserver has read/write to private/templates/cache
* To populate data MODE in config.php must not be PRODUCTION
* Request /api/process/data to parse & process data into database

Meta
----

* Code: `https://github.com/bigterminal/interactive_budget.git`
* Home: <http://interactivebudget.ca>
* Data: <http://data.gc.ca/data/en/dataset/69249c7f-e565-41e3-85a4-2fa798c314b1>