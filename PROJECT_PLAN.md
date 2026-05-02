# Loop Project Plan

Loop is moving beyond the academic prototype stage and toward a real campus pilot.
The college report has been submitted; the next goal is a live, working TU Dublin
service that can be deployed, monitored, moderated, and improved over time.

Loop is a free, verified TU Dublin digital marketplace that helps students and
staff exchange, donate, borrow, and reuse items across campus while tracking
sustainability impact over time.

It can be understood simply as:

> DoneDeal for students, but campus-verified, sustainability-focused, and built
> around reuse.

That simple explanation is useful, but Loop should stay broader than a buy/sell
site. It should support student-to-student exchange, academic reuse, campus
community, free and donation culture, simple personalisation, and safer reuse in a
verified college environment.

## 1. Product Vision

Loop should make it easy for TU Dublin students and staff to:

- sell useful second-hand items
- swap items with other students
- borrow or lend practical campus items
- donate or give away things that still have value
- find academic materials, tools, equipment, and course supplies
- reuse items instead of throwing them away
- discover relevant listings based on interests, campus, and activity

Loop is not only for electronics. It should support books, course materials,
clothes, furniture, bikes, kitchen items, music gear, art supplies, tools,
repair parts, lab items, accommodation bits, and everyday student essentials.

The product identity should stay practical:

- free to use
- no monetisation for now
- student and community focused
- low friction
- mobile-friendly
- sustainability-focused without being preachy
- understandable for a student who just wants to post or find something quickly

## 2. Current Working State

Loop is now past the static prototype and report-demonstration stage. The current
project is a PHP/MySQL web app with real marketplace behaviour already in place.

Implemented features to preserve:

- PHP/MySQL project
- login/register/logout
- protected dashboard
- create listing form
- database-backed listings
- seeded demo listings
- marketplace feed
- listing detail page
- image upload support
- local placeholder SVG listing images
- profile interests
- simple recommendation scoring
- saved listings

Current direction:

- Keep the existing PHP/MySQL stack.
- Keep the current project maintainable and understandable.
- Build forward from the working version instead of restarting.
- Do not migrate to React, Laravel, or another framework for the pilot.
- Do not redesign Loop into a corporate SaaS product.

## 3. Launch Philosophy

The launch version should be small, safe, and useful.

Loop does not need every clever feature before it reaches real users. It needs the
core service to work reliably:

- students can register and verify they belong to the college community
- verified users can create, save, and respond to listings
- users can browse and search listings easily
- owners can manage their own listings
- reported content can be reviewed
- administrators can hide unsafe or inappropriate listings
- the project can be deployed with backups, logging, and basic security
- usage can be tracked in a privacy-friendly way

The pilot should prove whether students actually use Loop, what they post, what
they save, what causes friction, and what moderation issues appear.

## 4. MVP Launch Requirements

The MVP launch should include only what is needed for a real campus pilot.

Core marketplace:

- register, login, logout
- verified account state
- marketplace feed
- listing detail page
- create listing
- image upload
- saved listings
- search and filters
- owner-only listing controls
- My Listings page
- Edit Listing page
- listing status: active, unavailable, reused, archived
- mark listing as reused/completed

Core trust and safety:

- TU Dublin email verification or equivalent lightweight verification
- report listing button
- admin review page
- admin ability to hide/remove listings
- admin ability to suspend accounts
- clear acceptable-use rules
- basic audit trail for moderation actions

Core launch support:

- production configuration
- HTTPS
- secure upload handling
- private environment/config values
- database backup plan
- error logging
- public PHP errors disabled
- README and database setup notes updated

Useful but not essential for MVP:

- better recommendation reasons
- wanted listings
- campus preference shortcuts
- basic impact page
- contact/message workflow beyond a safe placeholder

## 5. Campus Verification Plan

Avoid Microsoft, Azure, or formal college SSO for the MVP. Institutional SSO may
be useful later, but it adds complexity, permissions work, and support overhead
before the pilot has proven enough.

Use lightweight verification first:

- require TU Dublin email domains where possible
- send a one-time verification link or code
- mark accounts as verified after the code/link is confirmed
- allow unverified accounts to browse only if desired
- require verification before posting listings
- require verification before saving listings
- require verification before contacting users
- add admin-approved invite codes later if email-domain verification is awkward
- keep Microsoft SSO as a future institutional integration, not an MVP blocker

Verification should answer one simple question:

> Is this person likely to be part of the TU Dublin community?

It does not need to solve every identity problem on day one.

## 6. Moderation And Misuse Monitoring

Loop needs practical moderation before it needs reputation scores or gamification.

Moderation roadmap:

- add a report listing button
- add report user later
- create an admin review page
- let admins hide listings
- let admins remove listings
- let admins suspend accounts
- record who took each moderation action and when
- store listing status changes
- keep deleted/removed records available to admins where appropriate
- add a simple contact/support email

Listing statuses:

- active
- unavailable
- reused
- archived
- hidden
- removed

Acceptable-use rules should be clear and short:

- no dangerous goods
- no illegal items
- no spam
- no harassment
- no scams
- no personal data leaks
- no commercial dumping
- no unsafe exchange behaviour

The first moderation system can be simple. The important thing is that unsafe or
inappropriate content can be reported, reviewed, and acted on quickly.

## 7. Deployment Readiness

Before any real pilot, Loop needs a production-readiness pass.

Launch checklist:

- choose production hosting
- enable HTTPS
- separate development and production config
- move secrets out of committed files
- confirm database credentials for production
- set up database backups
- protect uploaded files
- validate upload image size
- validate upload image type
- prevent executable uploads
- disable public PHP errors
- enable server-side error logging
- use prepared statements consistently
- create an admin account
- add privacy page
- add terms/acceptable-use page
- add contact/support email
- update GitHub repo
- update README
- add database setup notes
- document deployment steps
- document how to restore from backup

The deployment goal is not perfection. The goal is a small service that can run
safely enough for a controlled pilot.

## 8. Analytics And Usage Tracking

Loop should track progress without invasive analytics or ad-style tracking.

Internal metrics to collect:

- total users
- verified users
- active users this week
- active users this month
- total listings
- active listings
- reused/completed listings
- free/donation listings
- saved listings
- reports submitted
- listings by campus
- listings by category
- most used listing types
- basic growth over time

Avoid by default:

- external ad analytics
- invasive user tracking
- cross-site tracking
- unnecessary personal profiling

Analytics should help answer:

- Is Loop being used?
- What categories are useful?
- Which campuses are active?
- Are listings being reused or completed?
- Are reports or misuse increasing?
- Where are users getting stuck?

## 9. Pilot Launch Plan

Roll Loop out in phases.

### Stage 1: Local Test

- test with developer/admin accounts
- confirm register/login/logout
- confirm listing creation
- confirm image uploads
- confirm saved listings
- confirm listing detail pages
- confirm owner-only controls
- confirm basic moderation tools

### Stage 2: Trusted Student Test

- invite 3-5 trusted students
- seed realistic demo listings
- ask them to post real or test listings
- collect friction points
- fix confusing copy or broken flows
- check mobile layout on real phones

### Stage 3: Small Group Pilot

- test with one class, society, or small campus group
- require lightweight verification
- monitor reports and support messages
- track active users and listing creation
- ask what people expected but could not do

### Stage 4: Wider Campus Pilot

- invite more students gradually
- approach student union, societies, or sustainability office
- add clearer impact reporting
- improve onboarding and help text
- review moderation workload

### Stage 5: Live Service

- keep the site running
- maintain backups
- monitor errors
- review reports
- publish simple usage/impact updates
- plan features from real behaviour, not guesses

## 10. Post-Launch Roadmap

Prioritise the features that make Loop safer and easier to operate as a live
service.

### Near-Term After Launch

- My Listings page
- Edit Listing page
- better owner listing management
- mark reused/completed
- report listing
- admin moderation
- verified account flow
- basic stats dashboard

### Medium-Term

- better recommendations using saves, views, searches, and contacts
- recommendation reasons
- wanted listings
- campus preference
- near-my-campus shortcut
- better profile interests
- safer contact/message workflow
- impact page

### Longer-Term

- borrow/return workflow
- wanted-listing matching
- improved image handling
- notifications for saved searches or wanted matches
- stronger admin tools
- support for more campuses or partner groups
- exportable impact summary for sustainability teams

## 11. Future Community/Gamification Features

Seller ratings, feedback, badges, and leaderboards are useful ideas, but they are
not MVP features. They add moderation, fairness, and trust concerns, so they
should only come after verified accounts, reporting, and admin moderation are in
place.

Later, Loop may introduce:

- optional feedback after exchange
- seller/user ratings
- user trust score
- profile reputation
- donation badges
- reuse badges
- top reuser style badges
- campus impact leaderboard
- society or class reuse challenges
- gamified sustainability stats

These features should support trust and reuse, not turn Loop into a popularity
contest. They should be added carefully and tested with real users.

## 12. What Not To Build Yet

Do not build these for the MVP:

- payment systems
- complex messaging
- Microsoft/Azure/college SSO
- machine-learning recommendation models
- public leaderboards
- seller ratings
- feedback scores
- reputation badges
- delivery systems
- heavy notification systems
- corporate SaaS redesign
- framework migration
- monetisation

Loop should stay small, local, useful, and maintainable until the pilot proves
what students actually need.

## Personalisation Roadmap

Loop should become more personal over time, but it should start simple.

### Current Approach

- use explicit profile interests
- score category matches
- boost free/donation listings where relevant
- boost fresh listings
- keep search and filters available
- keep the feed understandable

### Next Signals

- listing views
- listing clicks
- saves
- searches
- contact attempts
- reused/completed listings
- hidden or reported listings

### Later Recommendation Reasons

- recommended because you like a category
- recommended because you saved similar listings
- popular near your campus
- new free item near you
- matches a wanted listing

Personalisation should help students find useful things faster. It should not
make the app mysterious or overcomplicated.

## Frictionless UX Checklist

Use this checklist before adding any feature:

- Can the user understand it in 3 seconds?
- Can the user complete the action in under 30 seconds?
- Is there a clear button?
- Is the form asking only what it really needs?
- Does it work on mobile?
- Is there a useful empty state?
- Does it avoid fake data pretending to be real?
- Does it help reuse, affordability, or sustainability?
- Does it make the marketplace feel more personal or useful?
- Does it keep the app easy to maintain?

## Next Best Step

The next best engineering steps are:

1. Commit and push current working version.
2. Run a production-readiness audit.
3. Build My Listings.
4. Build Edit Listing.
5. Add listing status: active / unavailable / reused / archived.
6. Add mark reused/completed.
7. Add Report Listing.
8. Add basic Admin Review page.
9. Add lightweight TU Dublin email verification.
10. Add production deployment checklist.
11. Add basic internal stats.
12. Deploy to staging.
13. Run a small pilot.

This is the practical path from working prototype to live campus service.
