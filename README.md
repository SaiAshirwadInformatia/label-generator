# Label Generator

A handy Web Based Application for generating Labels that are often used for Deliverable Goods.

## Anatomy

1. **Label** is identified for an Excel file to whose Labels are being generated
2. **Set** is a collection of several forms of Label PDF that can be generated from single Label of an Excel
3. **Field** are several items that can be displayed in tabular format for each Set
4. **Template** is a saved form of Label which can be repetatedly used for future similar Excels

## How to use

1. Click on **Generate Label** to start with your first label with the configuration required
2. Add set's for the number of PDF format you want to generate of
3. Configure fields each set will have
4. See instant real PDF preview in new tab
5. Click on **Generate PDF** button and wait for email in your inbox to download the PDF

## Features

1. Everything is logged, so you are aware with the data worked over
2. Configure your Sets and Fields dynamically
3. Determine the quantity of a group by using Sub-Count
4. Maintain your box no using Incremented value
5. Mechanism to add page break by Grouping data (often useful by not creating multiple PDF's for same set of data)

## Field Types

| name | description |
| -- | -- |
| Text | Displays same as seen in Excel |
| Static | Enter static value which is seen in each table generated in PDF |
| SubCount | Based on the group mechanism, displays the count of grouped data (eg. use for Quantity in a Box) |
| Incremented | Maintains a incremental count number (eg. Often useful for displaying Box No.) |
| Number | Type casts the value as Number |
| Float | Type casts the value as Float |
| Boolean | Updates value in Yes or No format |
| DD/MM/YYYY | Formats the date time value in "DD/MM/YYYY" format |
| INR | Prefixes with "Rs. " |
| EmptyRow | Adds a empty row in the table |

## Contribution Guide

[Read the guide and starting contributing](CONTRIBUTING.md)

## Contibutors

1. [Sai Ashirwad Informatia](https://saiashirwad.com)

## LICENSE

[MIT](LICENSE)