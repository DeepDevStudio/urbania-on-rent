import os, re, glob

# Exact mapping from image signature / pattern to approved descriptive ALT
image_alt_map = {
    # Vehicles
    'images/urbania-1.webp': '12 seater Urbania on rent with luxury Maharaja interior',
    'images/urbania-4.jpg': 'Luxury Force Urbania on rent in Delhi for outstation travel',
    'images/urbania-5.jpg': '16 seater Urbania on rent in Delhi for group travel',
    'images/urbania-rent.png': 'Luxury Force Urbania on rent in Delhi for group travel',

    # Agra
    'destinations/agra.jpg': 'Taj Mahal marble monument in Agra, Uttar Pradesh',
    'destinations/agra_fort.png': 'Red sandstone Mughal ramparts of Agra Fort in Uttar Pradesh',
    'destinations/agra_fatehpur_sikri.jpg': 'Buland Darwaza gateway at Fatehpur Sikri complex near Agra',

    # Ajmer
    'destinations/ajmer.jpg': 'Ajmer Sharif Dargah and Ana Sagar Lake promenade in Ajmer, Rajasthan',

    # Amritsar
    'destinations/amritsar.jpg': 'Golden Temple sanctum and holy sarovar in Amritsar, Punjab',
    'destinations/amritsar_jallianwala.jpg': 'Jallianwala Bagh memorial park in Amritsar, Punjab',
    'destinations/chandigarh.jpg': 'Sukhna Lake waterfront scenic promenade in Chandigarh',

    # Auli
    'destinations/auli.jpg': 'Snow-covered Himalayan slopes and ski resort in Auli, Uttarakhand',

    # Bikaner
    'destinations/bikaner.jpg': 'Junagarh Fort ornate red sandstone walls in Bikaner, Rajasthan',
    'destinations/bikaner-2.jpg': 'Lalgarh Palace heritage red sandstone courtyard in Bikaner, Rajasthan',
    'destinations/bikaner-3.jpg': 'Thar Desert camel safari and golden sand dunes in Bikaner, Rajasthan',

    # Chandigarh
    'Palace_of_Assembly_Chandigarh_2006.jpg': 'Palace of Assembly Capitol Complex architecture in Chandigarh',
    'Chandigarh_Architecture_Museum': 'Chandigarh Architecture Museum building in Sector 10 Chandigarh',
    'destinations/chandigarh_sukhna.jpg': 'Sukhna Lake pedal boats and scenic promenade in Chandigarh',

    # Dalhousie
    'destinations/dalhousie.jpg': 'Panchpula scenic waterfall and pine forests in Dalhousie, Himachal Pradesh',

    # Dehradun
    'destinations/dehradun.jpg': 'Forest Research Institute heritage building in Dehradun, Uttarakhand',
    'Forest_Research_Institute_campus': 'Forest Research Institute Greco-Roman colonial campus in Dehradun',
    'Mindroling1.jpg': 'Great Stupa and Mindrolling Monastery garden in Dehradun, Uttarakhand',

    # Dharamshala
    'destinations/dharamshala_landscape.jpg': 'Dhauladhar mountain range rising over Dharamshala, Himachal Pradesh',

    # Haridwar
    'destinations/haridwar_har_ki_pauri.jpg': 'Ganga river ghats at Har Ki Pauri during evening prayer in Haridwar, Uttarakhand',
    'destinations/haridwar_heritage.jpg': 'Sacred temples and Ganga river bridges in Haridwar, Uttarakhand',
    'destinations/haridwar_mansa_devi.jpg': 'Mansa Devi temple ropeway cable car hill view in Haridwar, Uttarakhand',

    # Jaipur
    'destinations/jaipur.jpg': 'Hawa Mahal palace facade in Jaipur, Rajasthan',
    'destinations/jaipur_jal_mahal.jpg': 'Jal Mahal water palace in the middle of Man Sagar Lake in Jaipur, Rajasthan',
    'destinations/jaipur_city_palace.jpg': 'Chandra Mahal and courtyards of City Palace in Jaipur, Rajasthan',

    # Jaisalmer
    'destinations/jaisalmer.jpg': 'Golden sandstone Jaisalmer Fort rising from the Thar Desert, Rajasthan',

    # Jodhpur
    'Mehrangarh_Fort_sanhita.jpg': 'Majestic Mehrangarh Fort overlooking the Blue City of Jodhpur, Rajasthan',
    'Jaswant_Thada_Dawn.jpg': 'Jaswant Thada white marble memorial cenotaph at dawn in Jodhpur, Rajasthan',
    'Umaid_Bhawan_Palace.jpg': 'Grand golden-yellow sandstone facade of Umaid Bhawan Palace in Jodhpur, Rajasthan',

    # Kasauli
    'destinations/kasauli.jpg': 'Gilbert Trail and pine covered hill slopes in Kasauli, Himachal Pradesh',

    # Kedarnath
    'destinations/kedarnath.jpg': 'Ancient Kedarnath Temple against snow-covered Himalayan peaks, Uttarakhand',

    # Lucknow
    'destinations/lucknow_authentic.jpg': 'Rumi Darwaza historic gateway in Lucknow, Uttar Pradesh',
    'destinations/lucknow_chota_imambara.png': 'Chota Imambara illuminated ornate historic monument in Lucknow, Uttar Pradesh',
    'destinations/lucknow_rumi_darwaza.png': 'Historic Awadhi architectural facade of Rumi Darwaza in Lucknow, Uttar Pradesh',

    # Manali
    'destinations/manali.jpg': 'Snow-covered mountain peaks and pine forests in Manali, Himachal Pradesh',
    'destinations/manali_hidimba.jpg': 'Ancient wooden Hidimba Devi Temple amidst cedar forests in Manali, Himachal Pradesh',
    'destinations/manali_rohtang.jpg': 'High Himalayan mountain pass and glaciers at Rohtang Pass near Manali',

    # Mathura
    'destinations/mathura.jpg': 'Shri Krishna Janmabhoomi temple complex on the banks of Yamuna river in Mathura, Uttar Pradesh',

    # Mussoorie
    'destinations/mussoorie.jpg': 'Scenic mountain valley and Himalayan views in Mussoorie, Uttarakhand',
    'Kempty_Waterfalls.jpg': 'Kempty Falls cascading mountain waterfall in Mussoorie, Uttarakhand',
    'Mussoorie_Snow_Over_Dehradun': 'Panoramic snow-capped Himalayan view over Doon valley from Mussoorie',

    # Nainital
    'destinations/nainital_heritage.jpg': 'Naini Lake boating and surrounding green hills in Nainital, Uttarakhand',

    # Pushkar
    'destinations/pushkar.jpg': 'Holy Pushkar Lake ghats and Brahma Temple pilgrimage town, Rajasthan',

    # Ranthambore
    'destinations/ranthambore.jpg': 'Royal Bengal Tiger in natural reserve habitat at Ranthambore National Park, Rajasthan',

    # Rishikesh
    'Trayambakeshwar_Temple_VK.jpg': 'Thirteen-story Trayambakeshwar Temple near Lakshman Jhula in Rishikesh, Uttarakhand',
    'Rishikesh-Lakshman_Jhula': 'Lakshman Jhula suspension bridge over river Ganga in Rishikesh, Uttarakhand',
    'Triveni_Ghat_Krishna_Arjun_Rath.jpg': 'Krishna Arjun Rath bronze chariot sculpture at Triveni Ghat in Rishikesh, Uttarakhand',

    # Shimla
    'Christ_Church%2C_Shimla.jpg': 'Historic neo-Gothic Christ Church on the Ridge in Shimla, Himachal Pradesh',
    'The_Ridge_Shimla_5.jpg': 'Panoramic pedestrian walkway of the Ridge in Shimla, Himachal Pradesh',
    'Mall_Road_Shimla_1.jpg': 'Colonial architecture and vibrant street life on Mall Road in Shimla, Himachal Pradesh',

    # Udaipur
    'destinations/udaipur.jpg': 'City Palace and Lake Pichola waterfront in Udaipur, Rajasthan',
    'destinations/udaipur_city_palace.jpg': 'Royal balconies and marble courtyards of City Palace in Udaipur, Rajasthan',
    'destinations/udaipur_lake.jpg': 'Lake Pichola boat ride with Jag Mandir Island Palace in Udaipur, Rajasthan',

    # Varanasi
    'Dasaswamedh_ghat-varanasi': 'Dashashwamedh Ghat during holy evening Ganga Aarti ceremony in Varanasi, Uttar Pradesh',
    'Assi_Ghat_Varanasi_morning_Aarti.jpg': 'Morning Subah-e-Banaras prayer ceremony at Assi Ghat in Varanasi, Uttar Pradesh',
    'Ancient_Buddhist_monasteries_near_Dhamekh_Stupa': 'Ancient Dhamekh Stupa and Buddhist monastery ruins at Sarnath near Varanasi',
}

def update_file(fname):
    with open(fname, 'r', encoding='utf-8') as f:
        content = f.read()

    modified_count = 0

    def get_replacement(match):
        nonlocal modified_count
        full_tag = match.group(0)
        src = match.group(1)

        matched_alt = None
        for key, alt in image_alt_map.items():
            if key in src:
                matched_alt = alt
                break

        if matched_alt:
            modified_count += 1
            new_tag = re.sub(r'\balt=[\'"][^\'"]*[\'"]', f'alt="{matched_alt}"', full_tag)
            return new_tag
        else:
            print(f"[{fname}] Warning: No key matched for src: {src}")
            return full_tag

    pattern = r'<img\s+[^>]*?src=[\'"]([^\'"]+)[\'"][^>]*?alt=[\'"]([^\'"]*)[\'"][^>]*?>'
    new_content = re.sub(pattern, get_replacement, content)

    if modified_count > 0:
        with open(fname, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"[{fname}] Successfully updated ({modified_count} images).")
    else:
        print(f"[{fname}] No modifications made.")
    return modified_count

total = 0
for f in sorted(glob.glob('delhi-to-*-urbania.php')):
    total += update_file(f)

print(f"\nCompleted! Total static route images updated: {total}")
