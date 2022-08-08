<?php

declare(strict_types=1);


namespace XoopsModules\Wgfaker;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgFaker module for xoops
 *
 * @copyright    2021 XOOPS Project (https://xoops.org)
 * @license      GPL 2.0 or later
 * @package      wgfaker
 * @since        1.0.0
 * @min_xoops    2.5.11 Beta1
 * @author       Goffy - Wedega - Email:webmaster@wedega.com - Website:https://xoops.wedega.com
 */

use XoopsModules\Wgfaker;


/**
 * Class Object Handler Datatype
 */
class DatatypeHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgfaker_datatype', Datatype::class, 'id', 'name');
    }

    /**
     * @param bool $isNew
     *
     * @return object
     */
    public function create($isNew = true)
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param int $id field id
     * @param null fields
     * @return \XoopsObject|null reference to the {@link Get} object
     */
    public function get($id = null, $fields = null)
    {
        return parent::get($id, $fields);
    }

    /**
     * get inserted id
     *
     * @param null
     * @return int reference to the {@link Get} object
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Datatype in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountDatatype($start = 0, $limit = 0, $sort = 'weight ASC, id', $order = 'ASC')
    {
        $crCountDatatype = new \CriteriaCompo();
        $crCountDatatype = $this->getDatatypeCriteria($crCountDatatype, $start, $limit, $sort, $order);
        return $this->getCount($crCountDatatype);
    }

    /**
     * Get All Datatype in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllDatatype($start = 0, $limit = 0, $sort = 'weight ASC, id', $order = 'ASC')
    {
        $crAllDatatype = new \CriteriaCompo();
        $crAllDatatype = $this->getDatatypeCriteria($crAllDatatype, $start, $limit, $sort, $order);
        return $this->getAll($crAllDatatype);
    }

    /**
     * Get Criteria Datatype
     * @param        $crDatatype
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getDatatypeCriteria($crDatatype, $start, $limit, $sort, $order)
    {
        $crDatatype->setStart($start);
        $crDatatype->setLimit($limit);
        $crDatatype->setSort($sort);
        $crDatatype->setOrder($order);
        return $crDatatype;
    }

    /**
     * Get Datatype
     * @param int    $i //iterator
     * @param string $field // field name
     * @param string $type // sql field type
     * @return int
     */
    public function getDatatype ($i, $field, $type) {

        $ret = Constants::DATATYPE_NONE;
        // search for fixed column names
        if (\in_array($field, ['submitter', 'uid'])) {
            $ret = Constants::DATATYPE_UID;
        }
        if (\in_array($field, ['datecreated'])) {
            $ret = Constants::DATATYPE_DATE;
        }
        if (\mb_strpos($field, 'datecreated') > 0) {
            $ret = Constants::DATATYPE_DATE;
        }

        // if no match till now then check column type
        if (0 == $ret) {
            if (\in_array($type, ['blob', 'text', 'mediumblob', 'mediumtext', 'longblob', 'longtext', 'enum', 'set'])) {
                $ret = Constants::DATATYPE_LOREMIPSUM;
            } elseif (\in_array($type, ['char', 'varchar'])) {
                if (\mb_strpos($field, 'file') > 0) {
                    $ret = Constants::DATATYPE_FILE;
                } elseif (\strpos($field, 'image') > 0 || \strpos($field, 'photo') > 0) {
                    $ret = Constants::DATATYPE_IMAGE;
                } else {
                    $ret = Constants::DATATYPE_TEXT;
                }
            } elseif (\in_array($type, ['int', 'integer', 'tinyint', 'smallint', 'mediumint', 'bigint'])) {
                $ret = Constants::DATATYPE_INTEGER;
            } elseif (\in_array($type, ['float', 'double', 'real'])) {
                $ret = Constants::DATATYPE_FLOAT;
            }
            if (Constants::DATATYPE_INTEGER == $ret && 1 == $i) {
                $ret = Constants::DATATYPE_AUTOINCREMENT;
            }
            if (Constants::DATATYPE_INTEGER == $ret && $i > 1 && \mb_strpos($field, 'date') > 0) {
                $ret = Constants::DATATYPE_DATE;
            }
            if (Constants::DATATYPE_INTEGER == $ret && $i > 1 && (\mb_strpos($field, 'uid') > 0 || \mb_strpos($field, 'submitter') > 0)) {
                $ret = Constants::DATATYPE_UID;
            }
        }
        return $ret;
    }

    /**
     * Create default datatype set
     * @param null
     * @return bool
     */
    public function createDefaultSet () {
        $helper = \XoopsModules\Wgfaker\Helper::getInstance();
        $datatypeHandler = $helper->getHandler('Datatype');

        $datatypes = [
            [Constants::DATATYPE_AUTOINCREMENT, 'AUTOINCREMENT', \_AM_WGFAKER_DATATYPE_AUTOINCREMENT],
            [Constants::DATATYPE_INTEGER, 'INTEGER', \_AM_WGFAKER_DATATYPE_INTEGER],
            [Constants::DATATYPE_INT_FIXED, 'INT_FIXED', \_AM_WGFAKER_DATATYPE_INT_FIXED],
            [Constants::DATATYPE_INT_RANGE, 'INT_RANGE', \_AM_WGFAKER_DATATYPE_INT_RANGE],
            [Constants::DATATYPE_INT_RUNNING, 'INT_RUNNING', \_AM_WGFAKER_DATATYPE_INT_RUNNING],
            [Constants::DATATYPE_FLOAT, 'FLOAT', \_AM_WGFAKER_DATATYPE_FLOAT],
            [Constants::DATATYPE_TEXT, 'TEXT', \_AM_WGFAKER_DATATYPE_TEXT],
            [Constants::DATATYPE_TEXT_FIXED, 'TEXT_FIXED', \_AM_WGFAKER_DATATYPE_TEXT_FIXED],
            [Constants::DATATYPE_TEXT_RUNNING, 'TEXT_RUNNING', \_AM_WGFAKER_DATATYPE_TEXT_RUNNING],
            [Constants::DATATYPE_LOREMIPSUM, 'LOREM_ISPUM', $this->getLoremIpsum()],
            [Constants::DATATYPE_LOREMIPSUM_SHORT, 'LOREM_ISPUM_SHORT', $this->getLoremIpsumShort()],
            [Constants::DATATYPE_FIRSTNAME, 'FIRSTNAME', $this->getFirstnameList()],
            [Constants::DATATYPE_LASTNAME, 'LASTNAME', $this->getLastnameList()],
            [Constants::DATATYPE_FIRSTLASTNAME, 'FIRSTLASTNAME', \_AM_WGFAKER_DATATYPE_FIRSTLASTNAME],
            [Constants::DATATYPE_EMAIL, 'EMAIL', \_AM_WGFAKER_DATATYPE_EMAIL],
            [Constants::DATATYPE_PHONE, 'PHONE', \_AM_WGFAKER_DATATYPE_PHONE],
            [Constants::DATATYPE_CITY, 'CITY', $this->getCityList()],
            [Constants::DATATYPE_STATE, 'STATE', $this->getStateList()],
            [Constants::DATATYPE_COUNTRY_CODE, 'COUNTRY_CODE', \_AM_WGFAKER_DATATYPE_COUNTRY_CODE],
            [Constants::DATATYPE_DATE, 'DATE', \_AM_WGFAKER_DATATYPE_DATE],
            [Constants::DATATYPE_DATE_RANGE, 'DATE_RANGE', \_AM_WGFAKER_DATATYPE_DATE_RANGE],
            [Constants::DATATYPE_DATE_NOW, 'DATE_NOW', \_AM_WGFAKER_DATATYPE_DATE_NOW],
            [Constants::DATATYPE_YESNO, 'YES_NO', \_AM_WGFAKER_DATATYPE_YES_NO],
            [Constants::DATATYPE_UID, 'UID', \_AM_WGFAKER_DATATYPE_UID],
            [Constants::DATATYPE_IP4, 'IP4', \_AM_WGFAKER_DATATYPE_IP4],
            [Constants::DATATYPE_IP6, 'IP6', \_AM_WGFAKER_DATATYPE_IP6],
            [Constants::DATATYPE_IMAGE, 'IMAGE', \_AM_WGFAKER_DATATYPE_IMAGE],
            [Constants::DATATYPE_FILE, 'FILE', \_AM_WGFAKER_DATATYPE_FILE],
            [Constants::DATATYPE_TABLE_ID, 'TABLE_ID', \_AM_WGFAKER_DATATYPE_TABLE_ID],
            [Constants::DATATYPE_PARENT_ID, 'PARENT_ID', \_AM_WGFAKER_DATATYPE_PARENT_ID],
            [Constants::DATATYPE_COLOR, 'COLOR', \_AM_WGFAKER_DATATYPE_COLOR],
            [Constants::DATATYPE_UUID, 'UUID', \_AM_WGFAKER_DATATYPE_UUID],
            [Constants::DATATYPE_LANG_CODE, 'LANG_CODE', \_AM_WGFAKER_DATATYPE_LANG_CODE],
            [Constants::DATATYPE_CUSTOM_LIST, 'CUSTOM_LIST', \_AM_WGFAKER_DATATYPE_CUSTOM_LIST],
            //[Constants::DATATYPE_ID_OF_MODULE, 'ID_OF_MODULE', '{random id of existing modules}'],
        ];

        foreach ($datatypes as $key => $datatype) {
            $datatypeObj = $datatypeHandler->create();
            // Set Vars
            $datatypeObj->setVar('id', $datatype[0]);
            $datatypeObj->setVar('name', $datatype[1]);
            $datatypeObj->setVar('values', $datatype[2]);
            $datatypeObj->setVar('weight', $key);
            $datatypeObj->setVar('datecreated', \time());
            $datatypeObj->setVar('submitter', $GLOBALS['xoopsUser']->uid());
            // Insert Data
            $datatypeHandler->insert($datatypeObj);
        }


        return true;
    }

    private function getFirstnameList() {
        return 'Abigail|Alexandra|Alison|Amanda|Amelia|Amy|Andrea|Angela|Anna|Anne|Audrey|Ava|Bella|Bernadette|Carol|Caroline|Carolyn|Chloe|Claire|Deirdre|Diana|Diane|Donna|Dorothy|Elizabeth|Ella|Emily|Emma|Faith|Felicity|Fiona|Gabrielle|Grace|Hannah|Heather|Irene|Jan|Jane|Jasmine|Jennifer|Jessica|Joan|Joanne|Julia|Karen|Katherine|Kimberly|Kylie|Lauren|Leah|Lillian|Lily|Lisa|Madeleine|Maria|Mary|Megan|Melanie|Michelle|Molly|Natalie|Nicola|Olivia|Penelope|Pippa|Rachel|Rebecca|Rose|Ruth|Sally|Samantha|Sarah|Sonia|Sophie|Stephanie|Sue|Theresa|Tracey|Una|Vanessa|Victoria|Virginia|Wanda|Wendy|Yvonne|Zoe|Adam|Adrian|Alan|Alexander|Andrew|Anthony|Austin|Benjamin|Blake|Boris|Brandon|Brian|Cameron|Carl|Charles|Christian|Christopher|Colin|Connor|Dan|David|Dominic|Dylan|Edward|Eric|Evan|Frank|Gavin|Gordon|Harry|Ian|Isaac|Jack|Jacob|Jake|James|Jason|Joe|John|Jonathan|Joseph|Joshua|Julian|Justin|Keith|Kevin|Leonard|Liam|Lucas|Luke|Matt|Max|Michael|Nathan|Neil|Nicholas|Oliver|Owen|Paul|Peter|Phil|Piers|Richard|Robert|Ryan|Sam|Sean|Sebastian|Simon|Stephen|Steven|Stewart|Thomas|Tim|Trevor|Victor|Warren|William';
    }
    private function getLastnameList() {
        return 'Abraham|Allan|Alsop|Anderson|Arnold|Avery|Bailey|Baker|Ball|Bell|Berry|Black|Blake|Bond|Bower|Brown|Buckland|Burgess|Butler|Cameron|Campbell|Carr|Chapman|Churchill|Clark|Clarkson|Coleman|Cornish|Davidson|Davies|Dickens|Dowd|Duncan|Dyer|Edmunds|Ellison|Ferguson|Fisher|Forsyth|Fraser|Gibson|Gill|Glover|Graham|Grant|Gray|Greene|Hamilton|Hardacre|Harris|Hart|Hemmings|Henderson|Hill|Hodges|Howard|Hudson|Hughes|Hunter|Ince|Jackson|James|Johnston|Jones|Kelly|Kerr|King|Knox|Lambert|Langdon|Lawrence|Lee|Lewis|Lyman|MacDonald|Mackay|Mackenzie|MacLeod|Manning|Marshall|Martin|Mathis|May|McDonald|McLean|McGrath|Metcalfe|Miller|Mills|Mitchell|Morgan|Morrison|Murray|Nash|Newman|Nolan|North|Ogden|Oliver|Paige|Parr|Parsons|Paterson|Payne|Peake|Peters|Piper|Poole|Powell|Pullman|Quinn|Rampling|Randall|Rees|Reid|Roberts|Robertson|Ross|Russell|Rutherford|Sanderson|Scott|Sharp|Short|Simpson|Skinner|Slater|Smith|Springer|Stewart|Sutherland|Taylor|Terry|Thomson|Tucker|Turner|Underwood|Vance|Vaughan|Walker|Wallace|Walsh|Watson|Welch|White|Wilkins|Wilson|Wright|Young';
    }
    private function getCityList() {
        return 'Abbeville|Aberdeen|Abilene|Abingdon|Abington|Acoma|Ada|Adams|Adrian|Aiken|Ajo|Akron|Alameda|Alamogordo|Alamosa|Albany|Albert Lea|Albuquerque|Alcoa|Alexander City|Alexandria|Alhambra|Aliquippa|Allentown|Alliance|Alma|Alpine|Alta|Alton|Altoona|Altus|Alva|Amana Colonies|Amarillo|Ambridge|American Fork|Americus|Ames|Amesbury|Amherst|Amsterdam|Anaconda|Anacortes|Anadarko|Anaheim|Anchorage|Andalusia|Anderson|Andersonville|Andover|Ann Arbor|Annapolis|Anniston|Ansonia|Antioch|Apalachicola|Appleton|Arcadia|Ardmore|Arkadelphia|Arkansas City|Arkansas Post|Arlington|Arlington Heights|Artesia|Arthur|Asbury Park|Asheboro|Asheville|Ashland|Ashtabula|Aspen|Astoria|Atchison|Athens|Athol|Atlanta|Atlantic City|Atmore|Attleboro|Auburn|Augusta|Aurora|Austin|Avondale|Babylon|Bainbridge|Baker City|Bakersfield|Baltimore|Bangor|Bar Harbor|Baraboo|Barberton|Barbourville|Bardstown|Barnstable|Barre|Barrington|Barstow|Bartlesville|Bartow|Bastrop|Batavia|Batesville|Bath|Baton Rouge|Battle Creek|Bay City|Bay Saint Louis|Bayonne|Baytown|Beacon|Beatrice|Beaufort|Beaumont|Beaverton|Beckley|Bedford|Belen|Belfast|Belle Fourche|Belle Glade|Bellefontaine|Belleville|Bellevue|Bellingham|Bellows Falls|Belmont|Beloit|Belvidere|Bemidji|Bend|Bennington|Benton|Benton Harbor|Berea|Berkeley|Berlin|Bessemer|Bethany|Bethesda-Chevy Chase|Bethlehem|Beverly|Beverly Hills|Biddeford|Big Spring|Billings|Biloxi|Binghamton|Birmingham|Bisbee|Bismarck|Blackfoot|Blairsville|Bloomfield|Bloomfield Hills|Bloomington|Bloomsburg|Bluefield|Blytheville|Boca Raton|Bogalusa|Boise|Bonners Ferry|Boone|Boonesborough|Boonville|Boothbay Harbor|Bordentown|Borger|Bossier City|Boston|Boulder|Boulder City|Bound Brook|Bountiful|Bourne|Bowie|Bowling Green|Boys Town|Bozeman|Bradenton|Bradford|Brainerd|Braintree|Branford|Branson|Brattleboro|Brea|Breckenridge|Bremerton|Bridgeport|Bridgeton|Brigham City|Brighton|Bristol|Brockton|Bronx|Brookfield|Brookings|Brookline|Brooklyn|Brownsville|Brunswick|Bryan|Buckhannon|Buena Park|Buffalo|Burbank|Burlington|Burns|Butte|Cadillac|Cahokia|Cairo|Calais|Caldwell|Calexico|Calhoun|Calistoga|Calumet City|Cambridge|Camden|Campbellsville|Canon City|Canton|Canyon|Cape Coral|Cape Girardeau|Cape May|Carbondale|Caribou|Carlinville|Carlisle|Carlsbad|Carmel|Carrollton|Carson City|Carthage|Casa Grande|Casper|Castine|Catonsville|Cedar City|Cedar Falls|Cedar Rapids|Central City|Central Falls|Centralia|Chadron|Chambersburg|Champaign|Chandler|Chanute|Chapel Hill|Charles City|Charles Town|Charleston|Charlestown|Charlevoix|Charlotte|Charlottesville|Chattanooga|Chautauqua|Cheboygan|Cheektowaga|Chelmsford|Chelsea|Cherokee|Chesapeake|Chester|Cheyenne|Chicago|Chicago Heights|Chickasaw|Chickasha|Chico|Chicopee|Chillicothe|Chula Vista|Cicero|Cincinnati|Clanton|Claremont|Claremore|Clarksburg|Clarksdale|Clarksville|Clayton|Clearfield|Clearwater|Cleburne|Cleveland|Cleveland Heights|Clifton|Climax|Clinton|Clovis|Cocoa Beach|Cocoa-Rockledge|Cody|Coeur d’Alene|Coffeyville|Cohasset|Cohoes|College Park|College Station|Collinsville|Colorado Springs|Columbia|Columbus|Compton|Concord|Coney Island|Conneaut|Connersville|Conway|Cookeville|Cooperstown|Coos Bay|Coral Gables|Cordova|Corinth|Corning|Corona|Coronado|Corpus Christi|Cortez|Cortland|Corvallis|Corydon|Costa Mesa|Coulee Dam|Council Bluffs|Council Grove|Coupeville|Coventry|Covington|Cranford|Cranston|Crawfordsville|Cripple Creek|Crookston|Crossett|Crown Point|Crystal City|Cullman|Culver City|Cumberland|Cushing|Custer|Cuyahoga Falls|Dahlonega|Dallas|Dalton|Daly City|Danbury|Danvers|Danville|Darien|Darlington|Dartmouth|Davenport|Davis|Dayton|Daytona Beach|De Land|De Smet|Deadwood|Dearborn|Decatur|Dedham|Deerfield Beach|Defiance|DeKalb|Del Rio|Delaware|Delray Beach|Delta|Deming|Demopolis|Denison|Dennis|Denton|Denver|Derby|Derry|Des Moines|Des Plaines|Detroit|Devils Lake|Dickinson|Dillon|Dixon|Dodge City|Dothan|Douglas|Dover|Downey|Dubuque|Duluth|Duncan|Dunkirk|Durango|Durant|Durham|Duxbury|Eagle Pass|East Aurora|East Chicago|East Cleveland|East Greenwich|East Hampton|East Hartford|East Haven|East Lansing|East Liverpool|East Moline|East Orange|East Point|East Providence|East Saint Louis|Eastchester|Eastham|Easton|Eastpointe|Eastport|Eau Claire|Ecorse|Edenton|Edgartown|Edinburg|Edison|Edmond|Effingham|El Centro|El Cerrito|El Dorado|El Monte|El Paso|El Reno|Elgin|Elizabeth|Elizabeth City|Elizabethton|Elizabethtown|Elk City|Elkhart|Elkins|Elko|Elkton|Ellensburg|Ellsworth|Elmhurst|Elmira|Elwood|Ely|Elyria|Emmitsburg|Emporia|Enfield|Englewood|Enid|Enterprise|Ephrata|Erie|Escanaba|Escondido|Essex|Estes Park|Estherville|Euclid|Eufaula|Eugene|Eureka|Evanston|Evansville|Eveleth|Everett|Excelsior Springs|Exeter|Fairbanks|Fairfax|Fairfield|Fairhaven|Fairmont|Fall River|Fallon|Falls Church|Falmouth|Fargo|Faribault|Farmington|Fayetteville|Fergus Falls|Ferguson|Fernandina Beach|Fillmore|Findlay|Fitchburg|Fitzgerald|Flagstaff|Flint|Florence|Florissant|Flushing|Fond du Lac|Fontana|Forest Hills|Forrest City|Fort Benton|Fort Collins|Fort Dodge|Fort Kent|Fort Lauderdale|Fort Lee|Fort Morgan|Fort Myers|Fort Payne|Fort Pierce|Fort Scott|Fort Smith|Fort Valley|Fort Walton Beach|Fort Wayne|Fort Worth|Framingham|Frankfort|Franklin|Frederick|Fredericksburg|Fredonia|Freeport|Fremont|French Lick|Fresno|Fullerton|Fulton|Gadsden|Gaffney|Gainesville|Galena|Galesburg|Gallatin|Gallipolis|Gallup|Galveston|Garden City|Garden Grove|Gardiner|Garland|Gary|Gastonia|Gatlinburg|Geneva|Genoa|Georgetown|Germantown|Gettysburg|Gila Bend|Gillette|Glassboro|Glen Ellyn|Glendale|Glendive|Glens Falls|Glenview|Glenwood Springs|Globe|Gloucester|Gloversville|Golden|Goldfield|Goldsboro|Goliad|Goshen|Grafton|Grand Forks|Grand Haven|Grand Island|Grand Junction|Grand Rapids|Granite City|Grants|Grants Pass|Grayling|Great Barrington|Great Bend|Great Falls|Great Neck|Greeley|Green Bay|Green River|Greenbelt|Greeneville|Greenfield|Greensboro|Greensburg|Greenville|Greenwich|Greenwood|Grenada|Gretna|Grinnell|Grosse Pointe|Groton|Guilford|Gulfport|Gunnison|Guntersville|Guthrie|Guymon|Hackensack|Haddonfield|Hagerstown|Haines|Halifax|Hallandale Beach|Hamden|Hamilton|Hammond|Hammondsport|Hampton|Hanalei|Hancock|Hannibal|Hanover|Harlan|Harlem|Harlingen|Harmony|Harpers Ferry|Harrisburg|Harrison|Harrodsburg|Hartford|Hartsville|Harwich|Hastings|Hattiesburg|Haverhill|Havre|Hays|Hayward|Hazard|Hazleton|Heber City|Helena|Hempstead|Henderson|Herkimer|Herrin|Hershey|Hialeah|Hibbing|Hickory|High Point|Highland Park|Hillsboro|Hillsborough|Hilo|Hingham|Hinton|Hobart|Hobbs|Hoboken|Hodgenville|Holdenville|Holland|Holly Springs|Hollywood|Holyoke|Homer|Homestead|Honaunau|Honesdale|Honolulu|Hood River|Hope|Hopewell|Hopkinsville|Hoquiam|Hot Springs|Houghton|Houlton|Houma|Houston|Hudson|Hugo|Huntington|Huntington Beach|Huntsville|Huron|Hutchinson|Hyannis|Hyattsville|Hyde Park|Idaho City|Idaho Falls|Ilion|Independence|Indiana|Indianapolis|Indianola|Indio|Inglewood|Interlochen|International Falls|Iowa City|Ipswich|Iron Mountain|Ironwood|Irvine|Irving|Irvington|Ishpeming|Ithaca|Jackson|Jacksonville|Jamestown|Janesville|Jasper|Jeannette|Jefferson City|Jeffersonville|Jersey City|Jim Thorpe|John Day|Johnson City|Johnstown|Joliet|Jonesboro|Jonesborough|Joplin|Junction City|Juneau|Kahului|Kalamazoo|Kalispell|Kanab|Kaneohe|Kankakee|Kansas City|Kapaa|Kaskaskia|Kawaihae|Kearney|Keene|Kellogg|Kelso|Kennebunkport|Kennewick|Kenosha|Kent|Keokuk|Ketchikan|Kettering|Kewanee|Key West|Keyser|Kilgore|Killeen|Kingman|Kingsport|Kingston|Kingsville|Kinston|Kirksville|Kittery|Kitty Hawk|Klamath Falls|Knoxville|Kodiak|Kokomo|Kotzebue|La Crosse|La Grande|La Grange|La Habra|La Junta|La Salle|Lackawanna|Laconia|Lafayette|Laguna Beach|Lahaina|Laie|Lake Charles|Lake City|Lake Forest|Lake Geneva|Lake Havasu City|Lake Oswego|Lake Placid|Lake Wales|Lakehurst|Lakeland|Lakeview|Lakewood|Lamar|Lancaster|Lander|Lansing|Laramie|Laredo|Largo|Las Cruces|Las Vegas|Laurel|Lawrence|Lawton|Layton|Lead|Leadville|Leavenworth|Lebanon|Lehi|Lenox|Leominster|Levittown|Lewes|Lewisburg|Lewiston|Lewistown|Lexington|Liberal|Libertyville|Lima|Lincoln|Lisle|Litchfield|Little Falls|Little Rock|Littleton|Livermore|Livingston|Livonia|Lock Haven|Lockport|Lodi|Logan|Lombard|Lompoc|Long Beach|Long Branch|Longmont|Longview|Lorain|Los Alamos|Los Angeles|Louisville|Loveland|Lovington|Lowell|Lower Southampton|Lubbock|Lubec|Ludington|Ludlow|Lufkin|Lumberton|Lynchburg|Lynn|Machias|Mackinaw City|Macomb|Macon|Madison|Magnolia|Malden|Malibu|Mamaroneck|Manassas|Manchester|Mandan|Manhattan|Manistee|Manitowoc|Mankato|Mansfield|Manti|Marblehead|Marietta|Marinette|Marion|Marlborough|Marquette|Marshall|Martinez|Martins Ferry|Martinsburg|Martinsville|Marysville|Maryville|Mason City|Massena|Massillon|Mattoon|Mayfield|Maysville|McAlester|McAllen|McCook|McKeesport|McKinney|McMinnville|McPherson|Meadville|Medford|Medicine Lodge|Melbourne|Memphis|Menasha|Menlo Park|Menominee|Mentor|Merced|Meriden|Meridian|Mesa|Mesquite|Mexico|Miami|Miami Beach|Michigan City|Middlebury|Middlesboro|Middletown|Midland|Midwest City|Milan|Milbank|Miles City|Milford|Millburn|Milledgeville|Millville|Milton|Milwaukee|Minden|Mineola|Minneapolis|Minot|Mishawaka|Mission|Missoula|Mitchell|Moab|Mobile|Mobridge|Modesto|Moline|Monett|Monmouth|Monroe|Monroeville|Montclair|Monterey|Montgomery|Monticello|Montpelier|Montrose|Moore|Moorhead|Morehead City|Morgan City|Morganton|Morgantown|Morrilton|Morristown|Moscow|Moses Lake|Moundsville|Mount Clemens|Mount Holly|Mount Pleasant|Mount Vernon|Mountain View|Muncie|Mundelein|Murfreesboro|Murray|Muscatine|Muskegon|Muskogee|Myrtle Beach|Mystic|Nacogdoches|Nags Head|Nahant|Nampa|Nanticoke|Napa|Naperville|Naples|Nappanee|Narragansett|Nashua|Nashville|Natchez|Natchitoches|Natick|Naugatuck|Nauvoo|Nebraska City|Needles|Neenah|Neosho|Nephi|New Albany|New Bedford|New Bern|New Braunfels|New Britain|New Brunswick|New Castle|New Glarus|New Harmony|New Haven|New Hope|New Iberia|New Kensington|New London|New Madrid|New Market|New Martinsville|New Milford|New Orleans|New Paltz|New Philadelphia|New Rochelle|New Smyrna Beach|New Ulm|New Windsor|New York City|Newark|Newberg|Newburgh|Newburyport|Newcastle|Newport|Newport Beach|Newport News|Newton|Niagara Falls|Niles|Nogales|Nome|Norfolk|Normal|Norman|Norris|Norristown|North Adams|North Chicago|North College Hill|North Haven|North Hempstead|North Kingstown|North Las Vegas|North Little Rock|North Platte|Northampton|Northfield|Norton|Norwalk|Norwich|Norwood|Novato|Nyack|Oak Harbor|Oak Park|Oak Ridge|Oakland|Oberlin|Ocala|Ocean City|Ocean Springs|Oceanside|Oconto|Odessa|Ogden|Ogdensburg|Oil City|Ojai|Oklahoma City|Okmulgee|Olathe|Old Saybrook|Olean|Olympia|Omaha|Oneida|Oneonta|Ontario|Opelika|Opelousas|Oraibi|Orange|Orangeburg|Orderville|Oregon|Oregon City|Orem|Orlando|Ormond Beach|Orono|Oroville|Osawatomie|Osceola|Oshkosh|Oskaloosa|Ossining|Oswego|Ottawa|Ottumwa|Ouray|Overland Park|Owatonna|Owensboro|Oxford|Oxnard|Oyster Bay|Ozark|Pacific Grove|Paducah|Pagosa Springs|Painesville|Palatine|Palatka|Palm Bay|Palm Beach|Palm Springs|Palmdale|Palmer|Palmyra|Palo Alto|Pampa|Panama City|Panguitch|Paris|Park City|Park Forest|Park Ridge|Parkersburg|Parma|Parsippany–Troy Hills|Pasadena|Pascagoula|Pasco|Pass Christian|Passaic|Paterson|Pauls Valley|Pawhuska|Pawtucket|Payson|Peabody|Pecos|Peekskill|Pekin|Pendleton|Pensacola|Peoria|Perry|Perth Amboy|Peru|Peshtigo|Petaluma|Peterborough|Petersburg|Petoskey|Pharr|Phenix City|Philadelphia|Philippi|Phoenix|Phoenixville|Pierre|Pine Bluff|Pinehurst|Pipestone|Piqua|Pittsburg|Pittsburgh|Pittsfield|Plainfield|Plains|Plainview|Plano|Plattsburgh|Plattsmouth|Plymouth|Pocatello|Point Pleasant|Point Roberts|Pomona|Pompano Beach|Ponca City|Pontiac|Port Angeles|Port Arthur|Port Gibson|Port Hueneme|Port Huron|Port Lavaca|Port Orford|Port Washington|Portage|Portales|Portland|Portsmouth|Potsdam|Pottstown|Pottsville|Poughkeepsie|Powell|Prairie du Chien|Prescott|Presque Isle|Price|Prichard|Priest River|Princeton|Prineville|Providence|Provincetown|Provo|Pryor|Pueblo|Pullman|Put-in-Bay|Puyallup|Queens|Quincy|Racine|Raleigh|Rancho Cucamonga|Randolph|Rantoul|Rapid City|Raton|Rawlins|Reading|Red Bluff|Red Cloud|Red Wing|Redding|Redlands|Redmond|Redondo Beach|Redwood City|Reedsport|Reno|Rensselaer|Renton|Reston|Revere|Rexburg|Rhinelander|Richardson|Richland|Richmond|Ridgewood|Ripon|River Forest|Riverside|Riverton|Roanoke|Rochester|Rock Hill|Rock Island|Rock Springs|Rockford|Rockland|Rockville|Rocky Mount|Rogers|Rolla|Rome|Romney|Roseburg|Roselle|Roseville|Roswell|Rotterdam|Royal Oak|Rugby|Rumford|Ruston|Rutherford|Rutland|Rye|Saco|Sacramento|Sag Harbor|Saginaw|Saint Albans|Saint Augustine|Saint Charles|Saint Cloud|Saint George|Saint Ignace|Saint Johnsbury|Saint Joseph|Saint Louis|Saint Martinville|Saint Marys City|Saint Paul|Saint Petersburg|Sainte Genevieve|Salem|Salina|Salinas|Salisbury|Sallisaw|Salt Lake City|San Angelo|San Antonio|San Bernardino|San Clemente|San Diego|San Felipe|San Fernando|San Francisco|San Gabriel|San Jose|San Juan Capistrano|San Leandro|San Luis Obispo|San Marcos|San Marino|San Mateo|San Pedro|San Rafael|San Simeon|Sand Springs|Sandusky|Sandwich|Sanford|Santa Ana|Santa Barbara|Santa Clara|Santa Clarita|Santa Claus|Santa Cruz|Santa Fe|Santa Monica|Santa Rosa|Sapulpa|Saranac Lake|Sarasota|Saratoga Springs|Saugus|Sauk Centre|Sault Sainte Marie|Sausalito|Savannah|Scarborough|Scarsdale|Schenectady|Scottsboro|Scottsdale|Scranton|Searcy|Seaside|Seattle|Sebring|Sedalia|Selma|Seminole|Seneca Falls|Seward|Seymour|Shaker Heights|Shamokin|Sharon|Shawnee|Shawneetown|Sheboygan|Sheffield|Shelby|Shelbyville|Shelton|Shepherdstown|Sheridan|Sherman|Shiprock|Shreveport|Sidney|Sierra Vista|Silver City|Silver Spring|Silverton|Simi Valley|Simsbury|Sioux City|Sioux Falls|Sitka|Skagway|Skokie|Smith Center|Smyrna|Socorro|Somersworth|Somerville|Sonoma|South Bend|South Charleston|South Hadley|South Holland|South Kingstown|South Orange Village|South Saint Paul|South San Francisco|Southampton|Southington|Spanish Fork|Sparks|Spartanburg|Spearfish|Spokane|Spring Green|Springfield|Springville|Stamford|Starkville|State College|Staten Island|Staunton|Steamboat Springs|Sterling|Steubenville|Stevens Point|Stillwater|Stockbridge|Stockton|Stonington|Stony Brook|Stony Point|Stoughton|Stratford|Streator|Stroudsburg|Sturbridge|Sturgeon Bay|Sturgis|Stuttgart|Sudbury|Suffolk|Summersville|Summit|Sumter|Sun Valley|Sunbury|Sunnyvale|Superior|Susanville|Swarthmore|Sweetwater|Sylacauga|Syracuse|Tacoma|Tahlequah|Takoma Park|Talladega|Tallahassee|Tamaqua|Tampa|Taos|Tarpon Springs|Tarrytown|Taunton|Telluride|Tempe|Temple|Ten Sleep|Terre Haute|Tewksbury|Texarkana|Texas City|The Dalles|The Village|Thermopolis|Thibodaux|Thousand Oaks|Ticonderoga|Tiffin|Tillamook|Titusville|Tiverton|Toccoa|Toledo|Tombstone|Tonawanda|Tooele|Topeka|Torrance|Torrington|Totowa|Towson|Traverse City|Trenton|Trinidad|Troy|Truro|Truth or Consequences|Tucson|Tucumcari|Tullahoma|Tulsa|Tupelo|Turlock|Tuscaloosa|Tuscumbia|Tuskegee|Twin Falls|Tyler|Ukiah|Union|Union City|Uniontown|Urbana|Utica|Uvalde|Vail|Valdez|Valdosta|Vallejo|Valley City|Valparaiso|Van Buren|Vancouver|Vandalia|Venice|Ventura|Vermillion|Vernal|Vicksburg|Victoria|Victorville|Vincennes|Vineland|Vinita|Virden|Virginia|Virginia Beach|Virginia City|Visalia|Wabash|Waco|Wahiawa|Wahpeton|Wailuku|Waimea|Walla Walla|Wallingford|Walnut Creek|Walpi|Walsenburg|Warm Springs|Warner Robins|Warren|Warrensburg|Warwick|Washington|Waterbury|Waterford|Waterloo|Watertown|Waterville|Watervliet|Watkins Glen|Watts|Waukegan|Waukesha|Wausau|Wauwatosa|Waycross|Wayne|Waynesboro|Weatherford|Webster|Webster City|Weehawken|Weirton|Welch|Wellesley|Wellfleet|Wellsburg|Wenatchee|West Allis|West Bend|West Bridgewater|West Chester|West Covina|West Des Moines|West Hartford|West Haven|West Lafayette|West Memphis|West New York|West Orange|West Palm Beach|West Plains|West Point|West Seneca|West Springfield|Westerly|Westfield|Westminster|Weston|Westport|Wethersfield|Wewoka|Weymouth|Wheaton|Wheeling|White Plains|White Springs|White Sulphur Springs|Whitman|Whittier|Wichita|Wichita Falls|Wickford|Wilkes-Barre|Williamsburg|Williamson|Williamsport|Williamstown|Willimantic|Willingboro|Williston|Willmar|Wilmette|Wilmington|Wilson|Winchester|Windham|Window Rock|Windsor|Windsor Locks|Winnemucca|Winnetka|Winona|Winooski|Winslow|Winsted|Winston-Salem|Winter Haven|Winter Park|Wisconsin Dells|Woburn|Wood River|Woodbridge|Woodland|Woods Hole|Woodstock|Woodward|Woonsocket|Wooster|Worcester|Worland|Worthington|Wyandotte|Xenia|Yakima|Yankton|Yazoo City|Yellow Springs|Yonkers|Yorba Linda|York|Youngstown|Ypsilanti|Ysleta|Yuba City|Yuma|Zanesville|Zion';
    }
    private function getStateList() {
        return 'Alabama|Alaska|Arizona|Arkansas|California|Colorado|Connecticut|Delaware|Florida|Georgia|Hawaii|Idaho|Illinois|Indiana|Iowa|Kansas|Kentucky|Louisiana|Maine|Maryland|Massachusetts|Michigan|Minnesota|Mississippi|Missouri|Montana|Nebraska|Nevada|New Hampshire|New Jersey|New Mexico|New York|North Carolina|North Dakota|Ohio|Oklahoma|Oregon|Pennsylvania|Rhode Island|South Carolina|South Dakota|Tennessee|Texas|Utah|Vermont|Virginia|Washington|West Virginia|Wisconsin|Wyoming';
    }
    private function getLoremIpsum() {
        return 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.';
    }
    private function getLoremIpsumShort() {
        return 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.';
    }
}
