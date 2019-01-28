#import <Foundation/Foundation.h>
#import "NSTask.h"
//#import "misc.h"
@interface device : NSObject {
   // NSString* uuid;
  //  NSString* udid;
}
- (id) GetUdid;
- (id) GetUuid: (NSString*)input;
- (id) GetInstalled;
- (id) ExecTicket: (NSString*)ticketid;
//- (id) Install: (NSString*)PkgList;
//- (id) Remove: (NSString*)Package;


//- (void) GetUdid;
@end
