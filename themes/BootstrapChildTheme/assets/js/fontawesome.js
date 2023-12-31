// FontAwesome Icons
// Import icons one by one to reduce size of the output
import { library, dom } from '@fortawesome/fontawesome-svg-core';

import { faAngleRight } from '@fortawesome/free-solid-svg-icons/faAngleRight';
import { faTiktok } from '@fortawesome/free-brands-svg-icons/faTiktok';
import { faBolt } from '@fortawesome/free-solid-svg-icons/faBolt';
import { faHeart } from '@fortawesome/free-solid-svg-icons/faHeart';
import { faList } from '@fortawesome/free-solid-svg-icons/faList';
import { faRemove } from '@fortawesome/free-solid-svg-icons/faRemove';
import { faCartShopping } from '@fortawesome/free-solid-svg-icons/faCartShopping';
import { faCopy } from '@fortawesome/free-solid-svg-icons/faCopy';
import { faFileExport } from '@fortawesome/free-solid-svg-icons/faFileExport';
import { faEdit } from '@fortawesome/free-solid-svg-icons/faEdit';

library.add(faTiktok, faAngleRight, faBolt, faHeart, faList, faRemove, faCartShopping, faCopy, faFileExport, faEdit);
dom.watch();
