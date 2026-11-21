import json
import re
import os
import math
from data_transformer_helper import (
    determine_state,
    determine_category,
    normalize_dest_name,
    generate_route_stops,
    clean_paragraphs_and_extract_info,
    get_best_image
)

with open('source_crawled_611.json', 'r', encoding='utf-8') as f:
    raw_list = json.load(f)

print(f"Total raw source items: {len(raw_list)}")

processed_routes = []
seen_slugs = set()
duplicates_count = 0
skipped_count = 0
errors_count = 0

for idx, item in enumerate(raw_list, 1):
    try:
        raw_slug = item['slug']
        base_dest_slug = raw_slug.replace('delhi-to-', '')
        base_dest_slug = re.sub(r'-(innova|cabs?|taxi|rental).*$', '', base_dest_slug)
        
        urbania_slug = f"delhi-to-{base_dest_slug}-urbania-on-rent"
        
        if urbania_slug in seen_slugs:
            duplicates_count += 1
            urbania_slug = f"{urbania_slug}-{idx}"
        seen_slugs.add(urbania_slug)
        
        raw_name = item.get('destination', '')
        dest_name = normalize_dest_name(raw_name, raw_slug)

        # Disambiguate multi-state names
        if 'rajasthan' in raw_slug.lower() and 'rajasthan' not in dest_name.lower():
            dest_name_full = f"{dest_name} (Rajasthan)"
        elif ('uttar-pradesh' in raw_slug.lower() or 'up' in raw_slug.lower()) and 'up' not in dest_name.lower():
            dest_name_full = f"{dest_name} (UP)"
        elif 'himachal' in raw_slug.lower() and 'himachal' not in dest_name.lower():
            dest_name_full = f"{dest_name} (HP)"
        elif raw_slug == 'delhi-to-badaun':
            dest_name_full = "Badaun"
        elif raw_slug == 'delhi-to-budaun':
            dest_name_full = "Budaun (UP)"
        else:
            dest_name_full = dest_name
        
        # Parse distance
        raw_dist_str = item.get('raw_distance') or ''
        dist_num = 250
        dist_match = re.search(r'(\d+)', str(raw_dist_str).replace(',', ''))
        if dist_match:
            dist_num = int(dist_match.group(1))
            if dist_num == 0 or dist_num > 3000:
                dist_num = 280
        else:
            dist_num = 280
            
        dist_display = f"{dist_num} km"
        
        # Parse duration
        raw_dur_str = item.get('raw_duration') or ''
        dur_display = ""
        dur_match = re.search(r'([\d\-.]+\s*(?:hours|hrs|hr|days))', str(raw_dur_str), re.I)
        if dur_match:
            dur_display = dur_match.group(1).strip()
        else:
            est_hours = round(dist_num / 45, 1)
            if est_hours < 2:
                dur_display = "2-3 hours"
            elif est_hours <= 5:
                dur_display = f"{int(est_hours)}-{int(est_hours)+1} hours"
            elif est_hours <= 12:
                dur_display = f"{int(est_hours)}-{int(est_hours)+2} hours"
            else:
                dur_display = f"{int(est_hours/12)} days"

        # State & Category
        detected_state = item.get('state_detected')
        paragraphs_text = " ".join(item.get('paragraphs', []))
        state = determine_state(dest_name, raw_slug, paragraphs_text, detected_state)
        category = determine_category(dest_name, state, dist_num)
        
        # Recommended duration
        if dist_num <= 180:
            rec_duration = "1 Day (Same Day Return)"
        elif dist_num <= 350:
            rec_duration = "2 Days / 1 Night"
        elif dist_num <= 600:
            rec_duration = "3 Days / 2 Nights"
        elif dist_num <= 900:
            rec_duration = "4 Days / 3 Nights"
        else:
            rec_duration = "5-6 Days Tour Package"

        # Route stops
        route_stops = generate_route_stops('Delhi', dest_name_full, state, dist_num)
        
        # Clean paragraphs & attractions
        clean_ps, attractions = clean_paragraphs_and_extract_info(item, dest_name_full, state)
        
        # Rich custom Urbania description
        if clean_ps and len(clean_ps[0]) > 60:
            primary_intro = clean_ps[0]
        else:
            primary_intro = f"{dest_name_full} is one of the most sought-after travel destinations from Delhi, situated in {state}. Known for its picturesque landscapes, rich cultural heritage, and smooth highway connectivity, it serves as a wonderful getaway for family vacations, friends group outings, and corporate offsites."
            
        full_description = f"{primary_intro} Traveling from Delhi to {dest_name_full} with a large group or family is effortless and luxurious with our chauffeur-driven Force Urbania rental service. Enjoy spacious reclining seats, individual AC vents, high-speed charging, and massive luggage capacity throughout the {dist_display} journey."

        # Route highlights
        highlights = [
            f"Smooth, well-connected highway journey of approx. {dist_display}",
            f"Spacious 9, 12 & 16 seater luxury Force Urbania options",
            f"Experienced outstation chauffeurs familiar with the Delhi to {dest_name_full} route",
            f"Customizable pick-up, drop-off, and sightseeing stops along the way"
        ]

        # Suggested Itinerary
        itinerary = [
            {
                "day": "Day 1",
                "title": f"Departure from Delhi to {dest_name_full}",
                "desc": f"Early morning pickup from Delhi NCR in your luxury Force Urbania. Enjoy a comfortable highway drive with refreshments en route. Check-in at {dest_name_full} and explore local evening attractions."
            },
            {
                "day": "Day 2",
                "title": f"{dest_name_full} Sightseeing & Local Exploration",
                "desc": f"After breakfast, explore prominent landmarks of {dest_name_full} including {', '.join(attractions[:2])}. Enjoy local cuisine, shopping, and scenic photography in the evening."
            },
            {
                "day": "Day 3",
                "title": f"Return Journey to Delhi NCR",
                "desc": f"Morning leisure, visit {attractions[2] if len(attractions)>2 else 'local spots'}, and begin your relaxed return journey to Delhi. Drop-off at your designated location in Delhi NCR."
            }
        ]

        # Hero Image with accurate real photography mapping
        hero_image = get_best_image(dest_name, base_dest_slug, state, category)

        # SEO Metadata
        meta_title = f"Delhi to {dest_name_full} Urbania on Rent | 9, 12, 16 Seater Luxury Van Hire"
        meta_description = f"Book luxury Force Urbania on rent from Delhi to {dest_name_full} with driver. Comfortable 9, 12 & 16 seater Urbania for group trips, family tours & corporate travel. Call +91 7290885949."
        focus_keyword = f"Delhi to {dest_name_full} Urbania on rent"

        # FAQs
        faqs = [
            {
                "q": f"What is the distance and travel time from Delhi to {dest_name_full}?",
                "a": f"The driving distance from Delhi to {dest_name_full} is approximately {dist_display}, which takes around {dur_display} depending on traffic and road conditions. Our experienced drivers ensure a smooth, timely journey."
            },
            {
                "q": f"Which Force Urbania seating configurations are available for {dest_name_full}?",
                "a": f"We offer 9 seater, 12 seater, and 16 seater luxury Force Urbania vans equipped with pushback seats, individual AC vents, and large luggage space."
            },
            {
                "q": f"Are toll taxes, state permits, and driver allowance included?",
                "a": f"We offer both all-inclusive packages (covering fuel, driver allowance, state tax/toll) as well as per-kilometer billing options starting from ₹40/km. Transparent billing with no hidden costs is guaranteed."
            },
            {
                "q": f"Can we customize our itinerary and add sightseeing stops in {dest_name_full}?",
                "a": f"Yes, all outstation Force Urbania bookings are 100% customizable. You can request multi-day itineraries, en-route food stops, and local sightseeing in and around {dest_name_full}."
            }
        ]

        route_data = {
            "id": idx,
            "origin": "Delhi",
            "destination": dest_name_full,
            "slug": urbania_slug,
            "base_slug": base_dest_slug,
            "source_slug": raw_slug,
            "state": state,
            "region": "North India" if state in ['Himachal Pradesh', 'Uttarakhand', 'Punjab', 'Haryana', 'Uttar Pradesh', 'Rajasthan', 'Jammu & Kashmir', 'Ladakh'] else "Central/Western India",
            "category": category,
            "distance": dist_num,
            "distance_str": dist_display,
            "estimated_travel_time": dur_display,
            "recommended_duration": rec_duration,
            "route_stops": route_stops,
            "highlights": highlights,
            "description": full_description,
            "nearby_places": attractions,
            "suggested_itinerary": itinerary,
            "hero_image": hero_image,
            "meta_title": meta_title,
            "meta_description": meta_description,
            "focus_keyword": focus_keyword,
            "faqs": faqs,
            "is_popular": idx <= 40 or category in ['Hill Stations', 'Religious & Pilgrimage'] and dist_num < 450
        }

        processed_routes.append(route_data)

    except Exception as e:
        errors_count += 1
        print(f"Error processing item #{idx} ({item.get('slug')}): {e}")

# Compute related routes
for r in processed_routes:
    same_state = [other['slug'] for other in processed_routes if other['state'] == r['state'] and other['slug'] != r['slug']]
    same_cat = [other['slug'] for other in processed_routes if other['category'] == r['category'] and other['slug'] != r['slug']]
    
    combined = []
    for s in same_state[:3]:
        if s not in combined:
            combined.append(s)
    for c in same_cat[:3]:
        if c not in combined and len(combined) < 4:
            combined.append(c)
            
    if len(combined) < 4:
        for other in processed_routes[:10]:
            if other['slug'] != r['slug'] and other['slug'] not in combined:
                combined.append(other['slug'])
            if len(combined) >= 4:
                break
                
    r['related_routes'] = combined[:4]

# Save to JSON
with open('includes/destinations_dataset.json', 'w', encoding='utf-8') as f:
    json.dump(processed_routes, f, indent=2)
with open('destinations_dataset.json', 'w', encoding='utf-8') as f:
    json.dump(processed_routes, f, indent=2)

print("Saved updated destinations_dataset.json with verified photography mappings.")
