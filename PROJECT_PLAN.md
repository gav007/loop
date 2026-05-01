# Loop Project Plan

Loop is a TU Dublin circular marketplace for students. The idea is simple:
make it easy for college students to sell, swap, borrow, donate, give away, and find useful second-hand items across campus.

Think of it as a digital college car boot sale, but smarter. Not just a static list of things. Loop should gradually learn what each student cares about and lift the most relevant listings higher in their marketplace feed.

## Product Vision

Loop should help students:

- save money
- reduce waste
- reuse useful items
- find campus-specific deals
- give unwanted items a second life
- discover items based on their interests

Loop is not only for tech. It should support books, course materials, clothes, furniture, music, instruments, bikes, kitchen items, gaming gear, art supplies, tools, and anything else students realistically trade or reuse.

## Core Idea

A normal marketplace shows the same feed to everyone.

Loop should eventually make each feed feel personal:

- Stacy likes CDs, vinyl, music, and free items, so music listings appear higher.
- Marvin likes drums, instruments, and audio gear, so drum-related listings appear higher.
- New listings still appear so the feed does not become stale.
- Search and filters always remain available.

The first version should keep this simple. Start with explicit interests that the user chooses. Later, Loop can learn from clicks, saves, searches, messages, claims, and hidden listings.

## Design Principles

College students have limited patience. The app must be low friction.

Important rules:

- Keep signup short.
- Do not force too many profile questions.
- Make posting a listing quick.
- Use plain language.
- Keep buttons obvious.
- Keep feeds scannable.
- Do not bury search and filters.
- Do not require perfect photos or long descriptions.
- Make free/swap/donation listings easy to spot.
- Keep the dashboard simple.
- Put browsing and discovery in the marketplace.

If a feature takes too much effort, students will ignore it.

## Current Phase

Current implemented direction:

- PHP/MySQL project
- login/register/logout
- protected dashboard
- create listing form
- database-backed listings
- seeded demo listings
- marketplace feed
- profile interests
- simple recommendation scoring
- saved listings
- local placeholder SVG listing images

## Phase Checklist

### Phase 1: UI Cleanup And Product Direction

Goal: make the prototype feel like Loop, not a generic form project.

- [x] Keep existing PHP/CSS structure.
- [x] Keep Loop visual identity.
- [x] Broaden copy beyond electronics.
- [x] Simplify dashboard into a launchpad.
- [x] Make marketplace the main browsing/feed page.
- [x] Normalize listing types.
- [x] Add TU Dublin campus options.
- [x] Expand categories.
- [x] Fix inconsistent button styles.
- [x] Improve empty states.
- [x] Protect logged-in pages.

### Phase 2: Real Marketplace Foundation

Goal: make the marketplace real enough to browse and demo.

- [x] Add `listings` table.
- [x] Add `user_interests` table.
- [x] Add SQL setup file.
- [x] Add demo seed listings.
- [x] Add local listing placeholder images.
- [x] Add create listing backend handler.
- [x] Save listings to MySQL.
- [x] Render listings from MySQL.
- [x] Add working search/filter basics.
- [x] Add profile interest checkboxes.
- [x] Save interests to MySQL.
- [x] Add simple recommendation scoring.
- [x] Keep dashboard simple with a profile/interests prompt.

### Phase 3: Listing Detail And Trust

Goal: make listings feel usable and credible.

- [x] Add listing detail page.
- [x] Link listing cards to listing detail.
- [x] Show full description, campus, date, condition, price, and owner.
- [x] Add clear listing status labels.
- [ ] Add report/remove placeholder for safety.
- [x] Add contact/message placeholder.
- [x] Add "mark as claimed" or "mark unavailable" for listing owner.
- [x] Prevent users from editing/deleting other users' listings.
- [ ] Add owner-only edit listing page.
- [x] Add owner-only delete/archive listing action.

### Phase 4: Lower-Friction Listing Creation

Goal: make posting quick enough that students will actually do it.

- [ ] Reduce form friction where possible.
- [ ] Add helper text for price based on listing type.
- [ ] Hide price when listing type is free/donation/wanted/borrow where appropriate.
- [x] Add image upload support.
- [x] Validate image type and size.
- [x] Add default category image fallback.
- [ ] Keep listing creation under one page.
- [ ] Add success state after posting.
- [ ] Add "post another" option.

### Phase 5: Better Marketplace Browsing

Goal: make the feed easier to scan and search.

- [ ] Add listing count by filter result.
- [ ] Add clear filter reset button.
- [ ] Add active filter chips.
- [ ] Improve mobile filter layout.
- [ ] Add "free only" shortcut.
- [ ] Add "near my campus" shortcut.
- [ ] Add "new this week" shortcut.
- [ ] Keep Recommended, Newest, Free first, and Lowest price sorting.
- [ ] Add empty states for filtered searches.

### Phase 6: Personalisation Loop

Goal: make the feed feel different for different users.

Start simple:

- [x] Use explicit interests selected in profile.
- [x] Score category matches.
- [x] Boost free/donation if user likes free items.
- [x] Boost fresh listings.

Next:

- [ ] Track listing views.
- [ ] Track listing clicks.
- [ ] Track saves.
- [ ] Track searches.
- [ ] Track messages/contact attempts.
- [ ] Track claimed/bought/swapped items.
- [ ] Track hidden listings.
- [ ] Add `user_activity` table.
- [ ] Update interest weights from behaviour.
- [ ] Show simple recommendation reasons.

Example scoring later:

- view: +1
- click: +3
- save: +8
- message/contact: +12
- claim/buy/swap: +20
- hide: -10

### Phase 7: Save Items

Goal: let students come back to listings.

- [x] Add `saved_listings` table.
- [x] Make save button functional.
- [x] Add saved items profile section.
- [x] Add saved item count on dashboard.
- [x] Use saved items as a recommendation signal.
- [x] Show "saved" state on listing cards.
- [x] Keep save action one click.

### Phase 8: Sustainability Impact

Goal: show Loop's purpose without making it feel preachy.

- [ ] Add lightweight impact page.
- [ ] Track number of active listings.
- [ ] Track free/donation listings.
- [ ] Track completed swaps/claims.
- [ ] Estimate money saved.
- [ ] Estimate waste diverted.
- [ ] Show simple campus impact stats.
- [ ] Keep dashboard impact teaser small.

Possible stats:

- items reused
- free items claimed
- active swaps
- donation listings
- estimated money saved
- estimated waste diverted

### Phase 9: Campus Community Features

Goal: make Loop feel local to TU Dublin.

- [ ] Add campus profile preference.
- [ ] Boost listings from user's campus.
- [ ] Add campus filter shortcut.
- [ ] Add wanted listings.
- [ ] Match wanted listings with new posts.
- [ ] Add borrow/return guidance.
- [ ] Add safe exchange tips.

### Phase 10: Polish And Report Readiness

Goal: make the project easier to explain and submit.

- [ ] Update README after each major phase.
- [ ] Add screenshots.
- [ ] Add database setup notes.
- [ ] Add feature explanation for recommendation scoring.
- [ ] Add known limitations.
- [ ] Add future work section.
- [ ] Check accessibility labels and focus states.
- [ ] Check mobile layout.
- [ ] Test login/register/listing/profile flows.

## Frictionless UX Checklist

Use this checklist before adding any feature:

- [ ] Can the user understand it in 3 seconds?
- [ ] Can the user complete the action in under 30 seconds?
- [ ] Is there a clear button?
- [ ] Is the form asking only what it really needs?
- [ ] Does it work on mobile?
- [ ] Is there a useful empty state?
- [ ] Does it avoid fake data pretending to be real?
- [ ] Does it help reuse, affordability, or sustainability?
- [ ] Does it make the marketplace feel more personal or useful?

## Recommendation Roadmap

### Now

Use explicit profile interests.

Recommended score:

- category match
- free/donation interest
- swap boost
- freshness
- small discovery boost

### Next

Add behaviour signals:

- view
- click
- save
- search
- contact/message
- claim
- hide

### Later

Add explanations:

- Recommended because you like music.
- Recommended because you saved free items.
- Popular on your campus.
- New free item near you.

## What Not To Build Yet

Do not rush into:

- payment systems
- complex messaging
- admin dashboards
- machine learning models
- notifications
- delivery systems
- corporate-looking redesigns

Loop should stay small, useful, local, and easy to understand.

## Next Best Step

The next best engineering step is Phase 3:

1. Add listing detail page.
2. Add owner-only edit/archive listing actions.
3. Make listing cards link to full details.
4. Add a safe contact placeholder.

This makes the marketplace feel usable without adding too much complexity.
