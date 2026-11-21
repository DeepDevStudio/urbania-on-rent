import json
import re
import os

# Available destination images in the directory
available_images = os.listdir('images/destinations') if os.path.exists('images/destinations') else []
available_images_set = set(img.lower() for img in available_images)

# State mapping helper
STATE_PATTERNS = [
    (r'(?i)\b(manali|shimla|dharamshala|dalhousie|kasauli|kullu|kasol|spiti|jibhi|tirthan|mandi|solan|bilaspur|chamba|palampur|bir|mcleodganj|khajjiar|baddi|paonta|una|hamirpur|kangra|kinnaur|narkanda|rohtang|kaza|sangla|kalpa|chitkul|shoghi|mashobra|kufri|nalagarh|parwanoo|sundernagar|baijnath|jawalamukhi|chintpurni|naina devi|amb|himachal)\b', 'Himachal Pradesh'),
    (r'(?i)\b(rishikesh|haridwar|dehradun|mussoorie|nainital|auli|kedarnath|badrinath|gangotri|yamunotri|corbett|jim corbett|ranikhet|almora|kausani|mukteshwar|bhimtal|roorkee|haldwani|rudrapur|kashipur|ramnagar|lansdowne|chopta|tehri|uttarkashi|chamoli|rudraprayag|karnaprayag|devprayag|joshimath|pithoragarh|bageshwar|dhanaulti|kanatal|chakrata|kotdwar|vikasnagar|pantnagar|uttarakhand)\b', 'Uttarakhand'),
    (r'(?i)\b(jaipur|udaipur|jodhpur|jaisalmer|bikaner|ajmer|pushkar|mount abu|ranthambore|alwar|bharatpur|neemrana|khatu|salasar|chittorgarh|shekhawati|mandawa|jhunjhunu|sikar|kota|sawai madhopur|bhiwadi|behror|abhaneri|alsisar|anand|bagidora|balotra|banswara|baran|barmer|bayana|beawar|bhilwara|bundi|churu|dausa|dholpur|dungarpur|fatehpur|ganganagar|hanumangarh|jhalawar|karauli|kishangarh|kumbhalgarh|nagaur|nawalgarh|pali|phalodi|pratapgarh|rajsamand|ratangarh|sadulpur|salumber|sambhar|shahpura|sirohi|sri ganganagar|sujangarh|tonk|rajasthan)\b', 'Rajasthan'),
    (r'(?i)\b(agra|mathura|vrindavan|lucknow|varanasi|ayodhya|prayagraj|allahabad|kanpur|aligarh|bareilly|meerut|moradabad|saharanpur|gorakhpur|jhansi|muzaffarnagar|ghaziabad|noida|greater noida|hapur|bulandshahr|firozabad|mainpuri|etawah|farrukhabad|unnao|raebareli|amethi|sultanpur|pratapgarh|mirzapur|jaunpur|ghazipur|ballia|azamgarh|mau|deoria|kushinagar|basti|gonda|bahraich|sitapur|lakhimpur|hardoi|shahjahanpur|pilibhit|budaun|badaun|sambhal|amroha|rampur|bijnor|shamli|baghpat|barabanki|fatehpur|banda|chitrakoot|hamirpur|mahoba|lalitpur|kaushambi|sant kabir|siddharthnagar|shravasti|balrampur|chandauli|sonbhadra|bhadrak|bhadohi|kasganj|hathras|auraiya|kannauj|barsana|govardhan|gokul|nandgaon|uttar pradesh)\b', 'Uttar Pradesh'),
    (r'(?i)\b(amritsar|chandigarh|ludhiana|jalandhar|patiala|bathinda|pathankot|hoshiarpur|mohali|batala|moga|abohar|malerkotla|khanna|muktsar|barnala|firozpur|kapurthala|faridkot|rajpura|sangrur|fazilka|gurdaspur|kharar|gobindgarh|mansa|anandpur sahib|zirakpur|derabassi|nawanshahr|rupnagar|tarn taran|punjab)\b', 'Punjab'),
    (r'(?i)\b(gurgaon|gurugram|faridabad|panipat|ambala|karnal|sonipat|rohtak|hisar|panchkula|sirsa|bahadurgarh|jind|thanesar|kurukshetra|kaithal|rewari|palwal|yamunanagar|jagadhri|bhiwani|fatehabad|hansi|narnaul|manesar|sohna|jhajjar|charkhi dadri|narwana|tohana|pehowa|kundli|samalkha|murthal|ballabhgarh|hodal|haryana)\b', 'Haryana'),
    (r'(?i)\b(srinagar|jammu|katra|gulmarg|pahalgam|sonamarg|patnitop|vaishno devi|anantnag|baramulla|udhampur|kashmir)\b', 'Jammu & Kashmir'),
    (r'(?i)\b(leh|ladakh|kargil|nubra|pangong)\b', 'Ladakh'),
    (r'(?i)\b(gwalior|khajuraho|orchha|bhopal|indore|ujjain|jabalpur|sagar|satna|rewa|shivpuri|guna|morena|bhind|datia|neemuch|mandsaur|ratlam|pachmarhi|kanha|bandhavgarh|madhya pradesh)\b', 'Madhya Pradesh'),
    (r'(?i)\b(ahmedabad|surat|vadodara|rajkot|bhavnagar|jamnagar|junagadh|gandhinagar|bhuj|kutch|dwarka|somnath|statue of unity|ambaji|gujarat)\b', 'Gujarat'),
    (r'(?i)\b(mumbai|pune|nagpur|nashik|aurangabad|shirdi|maharashtra)\b', 'Maharashtra'),
    (r'(?i)\b(patna|gaya|bodh gaya|muzaffarpur|bhagalpur|nalanda|rajgir|bihar)\b', 'Bihar'),
]

def determine_state(name, raw_slug, text, detected):
    if detected and detected in ['Himachal Pradesh', 'Uttarakhand', 'Rajasthan', 'Uttar Pradesh', 'Punjab', 'Haryana', 'Jammu & Kashmir', 'Ladakh', 'Madhya Pradesh', 'Gujarat', 'Maharashtra', 'Bihar']:
        return detected
    combined = f"{name} {raw_slug} {text}"
    for pat, st in STATE_PATTERNS:
        if re.search(pat, combined):
            return st
    return 'North India'

def determine_category(name, state, dist):
    n = name.lower()
    if any(k in n for k in ['temple', 'dham', 'devi', 'sahib', 'shrine', 'dargah', 'vrindavan', 'mathura', 'ayodhya', 'varanasi', 'haridwar', 'rishikesh', 'kedarnath', 'badrinath', 'khatu', 'salasar', 'pushkar', 'amritsar', 'chitrakoot', 'ujjain', 'dwarka', 'somnath', 'katra', 'vaishno']):
        return 'Religious & Pilgrimage'
    if state == 'Himachal Pradesh' or state == 'Uttarakhand' or state in ['Jammu & Kashmir', 'Ladakh'] or any(k in n for k in ['manali', 'shimla', 'mussoorie', 'nainital', 'auli', 'dharamshala', 'dalhousie', 'kasauli', 'ranikhet', 'almora', 'kausani', 'mukteshwar', 'chopta', 'pahalgam', 'gulmarg']):
        return 'Hill Stations'
    if state == 'Rajasthan' or any(k in n for k in ['fort', 'palace', 'haveli', 'jaipur', 'udaipur', 'jodhpur', 'jaisalmer', 'bikaner', 'chittorgarh', 'mandawa', 'shekhawati']):
        return 'Heritage & Royal Rajasthan'
    if any(k in n for k in ['corbett', 'ranthambore', 'sarisk', 'national park', 'sanctuary', 'wildlife', 'safari', 'kanha', 'bandhavgarh', 'keoladeo', 'bharatpur']):
        return 'Wildlife & Nature'
    if dist and dist > 450:
        return 'Long Distance Routes'
    if dist and dist <= 250:
        return 'Weekend Getaways'
    return 'Popular Destinations'

def get_best_image(dest_name, slug, state, category):
    clean_dest = dest_name.lower().replace(' ', '-').replace('_', '-').replace('(', '').replace(')', '').strip()
    clean_slug = slug.lower().replace('_', '-').strip()
    
    # 1. Exact dedicated monument webp file
    for candidate in [f"{clean_slug}-urbania-on-rent.webp", f"{clean_dest}-urbania-on-rent.webp", f"{clean_slug}.webp", f"{clean_dest}.webp"]:
        if os.path.exists(os.path.join('images/destinations', candidate)):
            return f"images/destinations/{candidate}"
    
    # Check core key in slug
    clean_slug = slug.lower().replace('-', '_')
    for img in available_images:
        img_base = img.split('.')[0].lower()
        if img_base in clean_slug and len(img_base) >= 4:
            return f"images/destinations/{img}"

    # Specific city/destination mappings
    if any(k in clean_dest for k in ['jammu', 'katra', 'vaishno']):
        return 'images/destinations/katra.jpg'
    if any(k in clean_dest for k in ['pahalgam', 'gulmarg', 'srinagar', 'anantnag', 'sonamarg', 'kashmir']):
        return 'images/destinations/kashmir.jpg'
    if any(k in clean_dest for k in ['leh', 'ladakh', 'kargil', 'nubra', 'pangong']):
        return 'images/destinations/ladakh.jpg'
    if any(k in clean_dest for k in ['jaisalmer', 'sam_sand', 'thar']):
        return 'images/destinations/jaisalmer.jpg'
    if any(k in clean_dest for k in ['pushkar', 'brahma']):
        return 'images/destinations/pushkar.jpg'
    if any(k in clean_dest for k in ['kasauli', 'solan', 'dagshai', 'chail']):
        return 'images/destinations/kasauli.jpg'
    if any(k in clean_dest for k in ['amritsar', 'golden_temple', 'wagah']):
        return 'images/destinations/amritsar.jpg'
    if any(k in clean_dest for k in ['manali', 'solang', 'rohtang', 'atal']):
        return 'images/destinations/manali.jpg'
    if any(k in clean_dest for k in ['shimla', 'kufri', 'narkanda', 'mashobra']):
        return 'images/destinations/shimla.jpg'
    if any(k in clean_dest for k in ['rishikesh', 'haridwar', 'shivpuri']):
        return 'images/destinations/rishikesh.jpg'
    if any(k in clean_dest for k in ['nainital', 'bhimtal', 'mukteshwar', 'ranikhet', 'almora', 'kausani']):
        return 'images/destinations/nainital.jpg'
    if any(k in clean_dest for k in ['mussoorie', 'dehradun', 'dhanaulti', 'kanatal']):
        return 'images/destinations/mussoorie.jpg'
    if any(k in clean_dest for k in ['jaipur', 'amer', 'chomu', 'neemrana']):
        return 'images/destinations/jaipur.jpg'
    if any(k in clean_dest for k in ['udaipur', 'kumbhalgarh', 'nathdwara', 'chittorgarh']):
        return 'images/destinations/udaipur.jpg'
    if any(k in clean_dest for k in ['jodhpur', 'osian', 'pali']):
        return 'images/destinations/jodhpur.jpg'
    if any(k in clean_dest for k in ['agra', 'mathura', 'vrindavan', 'fatehpur_sikri']):
        return 'images/destinations/agra.jpg'
    if any(k in clean_dest for k in ['ayodhya', 'ram_mandir']):
        return 'images/destinations/ayodhya.png'
    if any(k in clean_dest for k in ['varanasi', 'kashi', 'sarnath']):
        return 'images/destinations/varanasi.jpg'
    if any(k in clean_dest for k in ['lucknow', 'kanpur']):
        return 'images/destinations/lucknow.jpg'
    if any(k in clean_dest for k in ['chandigarh', 'mohali', 'panchkula']):
        return 'images/destinations/chandigarh.jpg'

    # State level fallbacks with authentic photography
    if state == 'Jammu & Kashmir':
        return 'images/destinations/kashmir.jpg'
    elif state == 'Ladakh':
        return 'images/destinations/ladakh.jpg'
    elif state == 'Himachal Pradesh':
        return 'images/destinations/himachal.jpg'
    elif state == 'Uttarakhand':
        return 'images/destinations/uttarakhand.jpg'
    elif state == 'Rajasthan':
        return 'images/destinations/jaipur.jpg'
    elif state == 'Uttar Pradesh':
        return 'images/destinations/agra.jpg'
    elif state == 'Punjab':
        return 'images/destinations/punjab.jpg'
    elif state == 'Haryana':
        return 'images/destinations/haryana.jpg'
    elif category == 'Religious & Pilgrimage':
        return 'images/destinations/pilgrimage.jpg'
    elif category == 'Wildlife & Nature':
        return 'images/destinations/ranthambore.jpg'

    return 'images/destinations/golden-triangle.jpg'

def normalize_dest_name(name, slug):
    name = re.sub(r'\s+(Himachal Pradesh|Rajasthan|Uttarakhand|Uttar Pradesh|Punjab|Haryana|Up|Hp|Mp)$', '', name, flags=re.I)
    name = name.strip()
    name = name.replace('-', ' ').title()
    corrections = {
        'Agra Innova On Rent': 'Agra',
        'Abhaneri': 'Abhaneri',
        'Amb': 'Amb',
        'Anand': 'Anand',
        'Badaun': 'Budaun',
        'Baddi': 'Baddi',
        'Badrinath': 'Badrinath',
        'Bageshwar': 'Bageshwar',
        'Ayodhya': 'Ayodhya',
        'Khatu Shyam': 'Khatu Shyam Ji',
        'Vrindavan': 'Vrindavan',
        'Mathura': 'Mathura',
    }
    return corrections.get(name, name)

def generate_route_stops(origin, destination, state, dist):
    if state == 'Himachal Pradesh':
        return [origin, 'Sonipat', 'Panipat', 'Kurukshetra', 'Ambala', 'Chandigarh', 'Bilaspur / Swarghat', destination]
    elif state == 'Uttarakhand':
        return [origin, 'Ghaziabad', 'Meerut', 'Muzaffarnagar', 'Roorkee', 'Haridwar / Rishikesh', destination]
    elif state == 'Rajasthan':
        return [origin, 'Gurgaon', 'Neemrana', 'Kotputli', 'Shahpura', 'Jaipur Bypass', destination]
    elif state == 'Uttar Pradesh':
        if dist > 400:
            return [origin, 'Greater Noida', 'Yamuna Expressway', 'Agra Bypass', 'Agra-Lucknow Expressway', 'Purvanchal / NH', destination]
        else:
            return [origin, 'Noida / Greater Noida', 'Yamuna Expressway', 'Mathura', destination]
    elif state == 'Punjab':
        return [origin, 'Sonipat', 'Panipat', 'Karnal', 'Ambala', 'Ludhiana / Rajpura', destination]
    elif state == 'Haryana':
        return [origin, 'Kundli', 'Sonipat', 'Panipat / Rohtak', destination]
    elif state in ['Jammu & Kashmir', 'Ladakh']:
        return [origin, 'Panipat', 'Ambala', 'Ludhiana', 'Pathankot', 'Jammu', destination]
    else:
        return [origin, 'National Highway Bypass', 'Expressway Corridor', destination]

def clean_paragraphs_and_extract_info(raw_entry, dest_name, state):
    ps = raw_entry.get('paragraphs', [])
    clean_desc_parts = []
    attractions = []
    
    for p in ps:
        p_clean = re.sub(r'Innova Crysta|Innova|Crysta|Toyota Crysta|Toyota Innova', 'Force Urbania', p, flags=re.I)
        p_clean = re.sub(r'cabs?|taxi', 'rental', p_clean, flags=re.I)
        p_clean = re.sub(r'\+91[\d\s\-]+', '+91 7290885949', p_clean)
        p_clean = re.sub(r'innovacrystarent\.com', 'urbaniaonrentdelhi.co.in', p_clean, flags=re.I)
        p_clean = re.sub(r'rentonurbania@gmail\.com', 'rentonurbania@gmail.com', p_clean)
        
        if any(w in p_clean.lower() for w in ['famous for', 'home to', 'attractions include', 'features the', 'known for', 'visit', 'explore']):
            clean_desc_parts.append(p_clean)
            
            matches = re.findall(r'(?:famous for|home to|known for the|features the|visit the)\s+([A-Za-z0-9\s,\'–-]+?)(?:\.|\sand\s|\sas well)', p_clean, re.I)
            for m in matches:
                for item in re.split(r',|\sand\s', m):
                    item_clean = item.strip()
                    if 3 < len(item_clean) < 40 and item_clean.lower() not in ['india', 'state', 'town', 'city', 'region', 'delhi']:
                        attractions.append(item_clean.title())

    unique_attractions = []
    for a in attractions:
        if a not in unique_attractions and len(unique_attractions) < 5:
            unique_attractions.append(a)
    
    if len(unique_attractions) < 3:
        unique_attractions.extend([
            f'{dest_name} Heritage & City Center',
            f'Local Markets & Cultural Landmarks',
            f'Scenic Viewpoints & Natural Surroundings'
        ])
    unique_attractions = unique_attractions[:4]
    
    return clean_desc_parts, unique_attractions
