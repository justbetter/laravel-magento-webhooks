# Upgrade guide

# 1.x to 2.x

2.x introduces the use of a database to log files

## Database usage

A migration has been added to this package to keep historical data of all the event webhooks. This means that using a database has become mandatory.

## Scheduling clean up

In order to keep the logs from bloating up disk usage, we've added a `CleanLogsCommand` which defaults to a month if no parameters have been passed.
Add this to your scheduler.
