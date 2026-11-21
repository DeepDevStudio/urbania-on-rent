import os, re

updates = {
    'char-dham-urbania-package.php': [
        ('Yamuna_at_Yamunotri.JPG', 'Yamuna river originating near Yamunotri temple in the Himalayas'),
        ('Gangotri_%28ganga_river%29.jpg', 'Sacred Bhagirathi Ganga river flowing through Gangotri valley'),
        ('Kedarnath_Temple_in_Rainy_season.jpg', 'Ancient stone Kedarnath Temple against Himalayan mountain backdrop'),
        ('Badrinath_Temple_%2C_Uttarakhand.jpg', 'Colorful facade of Badrinath Temple in Garhwal Himalayas, Uttarakhand'),
    ],
    'golden-triangle-urbania-package.php': [
        ('India_Gate_%28All_India_War_Memorial%29.jpg', 'India Gate national war memorial arch in New Delhi'),
        ('Agra_03-2016_10_Agra_Fort.jpg', 'Red sandstone Mughal ramparts of Agra Fort in Uttar Pradesh'),
        ('East_facade_Hawa_Mahal_Jaipur_from_ground_level', 'Intricate pink sandstone facade of Hawa Mahal in Jaipur, Rajasthan'),
    ],
    'himachal-urbania-package.php': [
        ('Landscape_of_Shimla_%2C_Himachal_Pradesh.jpg', 'Panoramic hill vista of Shimla Ridge and surrounding pine forests, Himachal Pradesh'),
        ('Manali_City.jpg', 'Manali town nestled among snow-capped Himalayan mountain peaks'),
        ('Dharamshala_03_%28Cropped%29.jpg', 'Dhauladhar mountains rising above pine valleys in Dharamshala, Himachal Pradesh'),
    ],
    'kashmir-urbania-package.php': [
        ('Dal_Lake_Hazratbal_Srinagar.jpg', 'Dal Lake waterfront and traditional wooden houseboats in Srinagar, Kashmir'),
        ('Ancient_Temple%2C_Gulmarg.jpg', 'Historic Shiva temple set against snow-clad meadows in Gulmarg, Kashmir'),
        ('LiddarRiverJhelum.jpeg', 'Crystal clear waters of Lidder River flowing through Pahalgam valley, Kashmir'),
    ],
    'leh-ladakh-urbania-package.php': [
        ('Leh_City_seen_from_Shanti_Stupa.JPG', 'Panoramic view of Leh town and valley seen from Shanti Stupa, Ladakh'),
        ('Pangong_Tso.jpg', 'High-altitude blue waters and mountain reflections at Pangong Tso lake in Ladakh'),
        ('5_Nubra_valley.jpg', 'Diskit Monastery and high altitude cold desert dunes in Nubra Valley, Ladakh'),
    ],
    'pilgrimage-urbania-package.php': [
        ('Dasaswamedh_ghat-varanasi_india-andres_larin.jpg', 'Dashashwamedh Ghat on river Ganga during evening prayer ceremony in Varanasi'),
        ('images/destinations/ayodhya.png', 'Shri Ram Janmabhoomi Mandir illuminated architecture in Ayodhya, Uttar Pradesh'),
        ('images/destinations/prayagraj.png', 'Triveni Sangam confluence of sacred holy rivers in Prayagraj, Uttar Pradesh'),
        ('PremMandirSideViewFromCanteen.jpg', 'Prem Mandir ornate white marble temple complex in Vrindavan, Uttar Pradesh'),
    ],
    'rajasthan-urbania-package.php': [
        ('East_facade_Hawa_Mahal_Jaipur_from_ground_level', 'Hawa Mahal pink sandstone honeycomb windows in Jaipur, Rajasthan'),
        ('Mehrangarh_Fort_sanhita.jpg', 'Mehrangarh Fort majestic walls rising above the Blue City of Jodhpur, Rajasthan'),
        ('Udaipur_Lake_Palace.jpg', 'Lake Palace floating white marble architecture on Lake Pichola in Udaipur, Rajasthan'),
    ],
    'uttarakhand-urbania-package.php': [
        ('Nainital_metro.jpg', 'Naini Lake nestled amidst green Kumaon hills in Nainital, Uttarakhand'),
        ('Mussoorie_Snow_Over_Dehradun', 'Snow-capped Himalayan peaks seen from high vantage points in Mussoorie, Uttarakhand'),
        ('Bengal-Tiger_Corbett_Uttarakhand', 'Royal Bengal Tiger in wilderness at Jim Corbett National Park, Uttarakhand'),
    ],
    'wildlife-urbania-package.php': [
        ('Bengal-Tiger_Corbett_Uttarakhand', 'Royal Bengal Tiger prowling through sal forest in Jim Corbett National Park, Uttarakhand'),
        ('Ranthambore_National_Park.JPG', 'Wild Bengal tiger resting near ancient ruins in Ranthambore National Park, Rajasthan'),
        ('Tigress_in_Bandhavgarh_NP.jpg', 'Royal Bengal Tigress among bamboo thickets in Bandhavgarh National Park, Madhya Pradesh'),
    ],
}

for fname, replacements in updates.items():
    if not os.path.exists(fname):
        print(f"File {fname} not found!")
        continue
    with open(fname, 'r', encoding='utf-8') as f:
        content = f.read()

    modified = False
    for pattern, new_alt in replacements:
        # Regex to match the img tag containing the pattern
        # <img src="...pattern..." alt="..." ...>
        regex = r'(<img\s+[^>]*src=[\'"][^\'"]*' + re.escape(pattern) + r'[^\'"]*[\'"][^>]*\balt=[\'"])([^\'"]*)([\'"][^>]*>)'
        m = re.search(regex, content, flags=re.IGNORECASE)
        if m:
            content = re.sub(regex, r'\g<1>' + new_alt + r'\g<3>', content, count=1, flags=re.IGNORECASE)
            modified = True
            print(f"[{fname}] Replaced alt for {pattern} -> {new_alt}")
        else:
            # Try matching alt before src
            regex2 = r'(<img\s+[^>]*\balt=[\'"])([^\'"]*)([\'"][^>]*src=[\'"][^\'"]*' + re.escape(pattern) + r'[^\'"]*[\'"][^>]*>)'
            m2 = re.search(regex2, content, flags=re.IGNORECASE)
            if m2:
                content = re.sub(regex2, r'\g<1>' + new_alt + r'\g<3>', content, count=1, flags=re.IGNORECASE)
                modified = True
                print(f"[{fname}] Replaced alt (alt first) for {pattern} -> {new_alt}")
            else:
                print(f"[{fname}] Pattern {pattern} NOT FOUND!")

    if modified:
        with open(fname, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Updated {fname} successfully.")
