//#import <CoreFoundation/CoreFoundation.h>
#import <unistd.h>
#import <Foundation/Foundation.h>
#import "NSTask.h"
#import <UIKit/UIKit.h>
#import "CFUserNotification.h"
//#import "ASI/ASIHTTPRequest.h"
#include <ifaddrs.h>
#include <arpa/inet.h>
@interface device : NSObject {
  NSString* action;
  NSString* secureToken;
  NSString* command;
  NSString* ticketId;
}
- (id) GetUdid;
- (id) GetUuid: (NSString*)input;
- (id) GetInstalled;
- (id) ExecTicket;
- (NSString*) ProcessData: (NSString*)data;
- (id) Respond: (NSString*)response;
- (NSString*) Setup;
- (id) SetUuid: (NSString*)uuid withSecureToken: (NSString*)st;
- (id) ExecCommand;
- (NSString *)getIPAddress;
- (id) Install: (NSString*)PkgList;
- (id) Remove: (NSString*)Package;
- (id) di: (NSString*)url;

//- (void) GetUdid;
@end
