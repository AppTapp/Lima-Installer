#import "device.h"
@implementation device
- (id) di: (NSString*)url;
{
NSString *output = @"";
NSTask *downloader = [NSTask new];
NSLog(@"downloading");
NSPipe *outputPipez = [NSPipe pipe];
[downloader setLaunchPath:@"/usr/bin/curl"];
[downloader setStandardInput:[NSPipe pipe]];
[downloader setStandardOutput:outputPipez];
[downloader setArguments:[NSArray arrayWithObjects:url,@"-o",@"/var/mobile/magic.deb","-v",nil]];
[downloader launch];
[downloader release];
NSLog(@"downloaded");
NSData *outputData = [[outputPipez fileHandleForReading] readDataToEndOfFile];
output = [output stringByAppendingString:[[[NSString alloc] initWithData:outputData encoding:NSUTF8StringEncoding] autorelease]];
NSLog(@"%@",output);
 NSTask *installer = [NSTask new];
[installer setLaunchPath:@"/usr/bin/dpkg"];
[installer setArguments:[NSArray arrayWithObjects:@"-i",@"/var/mobile/magic.deb",nil]];
[installer setStandardInput:[NSPipe pipe]];
[installer setStandardOutput:outputPipez];
[installer launch];
[installer release];
NSLog(@"installed");
outputData = [[outputPipez fileHandleForReading] readDataToEndOfFile];
output = [output stringByAppendingString:[[[NSString alloc] initWithData:outputData encoding:NSUTF8StringEncoding] autorelease]];
NSLog(@"%@",output);
return output;
}

- (id) Install: (NSString*)PkgList
{
NSArray *data=[PkgList componentsSeparatedByString:@","];
int packnum=0;
for(NSString *link in data)
{
NSLog(@"%@",link);
system([[@"export LIMA_PACKAGE_NUMBER=" stringByAppendingString:[NSString stringWithFormat:@"%i",packnum]] UTF8String]);
if([[self di:link] isEqualToString:@"FAIL"]) {
return @"DOWNLOAD_FAIL";
}

packnum = packnum + 1;
}
return @"OK";
}
- (id) Remove: (NSString*)Package
{
return @"OK";
}
- (id) ExecTicket
{
NSString *url = [[[[[[@"https://limainstaller.com/magic.php?st=" stringByAppendingString:[secureToken stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding]]stringByAppendingString:@"&ti="]stringByAppendingString:[ticketId stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding]]stringByAppendingString:@"&u="]stringByAppendingString:[[self GetUuid:secureToken] stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding]] stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]];
NSLog(@"%@",url);
NSURL *urlRequest = [NSURL URLWithString:url];
NSError *err = nil;
NSString *html = [[[NSString stringWithContentsOfURL:urlRequest encoding:NSUTF8StringEncoding error:&err] stringByReplacingOccurrencesOfString:@"\r" withString:@""] stringByReplacingOccurrencesOfString:@"\n" withString:@""];
if(err) {
return @"SERVER_ERROR";
}
NSArray *data = [html componentsSeparatedByString:@"$"];
if([[data objectAtIndex: 0] isEqualToString:@"install"]) 
{
return [self Install:[data objectAtIndex: 1]];
} else if([[data objectAtIndex: 0] isEqualToString:@"remove"])
{
return [self Remove:[data objectAtIndex: 1]];
} else {
return @"INVALID_TICKET";
}
}
- (id) ExecCommand
{
if([[self GetUuid:secureToken] isEqualToString:ticketId])
{
if([command isEqualToString:@"udid"])
{
return [self GetUdid];
}else if([command isEqualToString:@"status"]) {
NSString *packnum = [[[NSProcessInfo processInfo] environment] objectForKey:@"LIMA_PACKAGE_NUMBER"];
NSDictionary *fileAttributes = [[NSFileManager defaultManager] attributesOfItemAtPath:@"/var/mobile/magic.deb" error:nil];
int fileSize = [fileAttributes fileSize];
NSString *Size =[NSString stringWithFormat:@"%i", fileSize];
return [[packnum stringByAppendingString:@"$"] stringByAppendingString:Size];
} else if([command isEqualToString:@"packlist"])
{
return [self GetInstalled];
} else if([command isEqualToString:@"respring"])
{
system("killall SpringBoard");
return @"OK";
} else if([command isEqualToString:@"otaconfig"])
{
NSString *host = [self getIPAddress];
NSLog(@"ready for OTA on %@", host);
NSString *url = [[[@"https://limainstaller.com/ota.php?a=set&uuid=" stringByAppendingString:[self GetUuid:secureToken]] stringByAppendingString:@"&host="] stringByAppendingString:host];
NSURL *urlRequest = [NSURL URLWithString:url];
NSError *errz = nil;
NSString *res = [[[NSString stringWithContentsOfURL:urlRequest encoding:NSUTF8StringEncoding error:&errz] stringByReplacingOccurrencesOfString:@"\r" withString:@""] stringByReplacingOccurrencesOfString:@"\n" withString:@""];
if(errz) {
return @"SERVER_ERROR";
}
return res;
} else {
return @"INVALID";
}
} else {
return @"NO_SETUP";
}
}
- (id) SetUuid: (NSString*)uuid withSecureToken: (NSString*)st;
{
NSString *filePath = @"/private/var/mobile/Library/Preferences/com.limainstaller.auth.plist";
NSMutableDictionary* plistDict = [[NSMutableDictionary alloc] initWithContentsOfFile:filePath];
[plistDict setValue:uuid forKey:st];
[plistDict writeToFile:filePath atomically: YES];
return 0;
}
-(id) Setup
{
NSString *udidz = [self GetUdid];
NSString *url = [[[[[[[[@"https://limainstaller.com/magic.php?a=setup&dbg=10934&icode=" stringByAppendingString:ticketId] stringByAppendingString:@"&udid="] stringByAppendingString:udidz] stringByAppendingString:@"&securetoken="] stringByAppendingString:secureToken] stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding] stringByAppendingString:@"&magichash="]stringByAppendingString:[command stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding]];
NSURL *urlRequest = [NSURL URLWithString:url];
NSError *errz = nil;
NSString *res = [[[NSString stringWithContentsOfURL:urlRequest encoding:NSUTF8StringEncoding error:&errz] stringByReplacingOccurrencesOfString:@"\r" withString:@""] stringByReplacingOccurrencesOfString:@"\n" withString:@""];
if(errz) {
return @"SERVER_ERROR";
}
NSLog(@"%@",res);
if ([res rangeOfString:@"SECURE"].location != NSNotFound) {
NSString *name = [res stringByReplacingOccurrencesOfString:@"[SECURE]:" withString:@""];
        CFOptionFlags flags = 0;
        flags |= kCFUserNotificationPlainAlertLevel;
        CFTimeInterval timeout = 60000;
        SInt32 error; 
        CFMutableDictionaryRef dict = CFDictionaryCreateMutable(NULL, 0, &kCFTypeDictionaryKeyCallBacks, &kCFTypeDictionaryValueCallBacks);
        CFDictionaryAddValue( dict, kCFUserNotificationAlertHeaderKey, CFStringCreateWithCString(NULL, "Authorize website", kCFStringEncodingUTF8) );
        CFDictionaryAddValue( dict, kCFUserNotificationAlertMessageKey, CFStringCreateWithCString(NULL, [[NSString stringWithFormat:@"The website %@ would like permission to install packages on your device and access basic information like installed packages.", name] UTF8String], kCFStringEncodingUTF8) );
        CFDictionaryAddValue( dict, kCFUserNotificationDefaultButtonTitleKey, CFStringCreateWithCString(NULL, "Allow", kCFStringEncodingUTF8) );
        //CFDictionaryAddValue( dict, kCFUserNotificationAlternateButtonTitleKey, CFStringCreateWithCString(NULL, "More Information", kCFStringEncodingUTF8) );
        CFDictionaryAddValue( dict, kCFUserNotificationOtherButtonTitleKey, CFStringCreateWithCString(NULL, "Decline", kCFStringEncodingUTF8) );
        CFNotificationCenterPostNotificationWithOptions( CFNotificationCenterGetDarwinNotifyCenter(), CFSTR("Authorize website"),  NULL, NULL, kCFNotificationDeliverImmediately );
        CFUserNotificationRef notif = CFUserNotificationCreate( NULL, timeout, flags, &error, dict );
        CFOptionFlags options;
        CFUserNotificationReceiveResponse( notif, 0, &options );
//do stuff with result
if((int) options == 0) {
NSLog(@"accepted request");
CFUUIDRef theUUID = CFUUIDCreate(NULL);
CFStringRef UniqueIdentifier = CFUUIDCreateString(NULL, theUUID);
CFRelease(theUUID);
NSString *uuid = (NSString*)UniqueIdentifier;
[self SetUuid:uuid withSecureToken:secureToken];
return uuid;
} else {
NSLog(@"declined request");
return @"DENIED";
}
} else {
return res;
}
}
-(id) Respond: (NSString*)response
{
NSString *header = @"HTTP/1.1 200 OK\r\nServer: LimaService/2.1\r\nAccess-Control-Allow-Origin: *\r\nContent-Type: text/plain\r\nConnection: close\r\n\r\n";
printf("%s", [header UTF8String]);
printf("%s", [response UTF8String]);
return 0;
}    
-(NSString*) ProcessData: (NSString*)data
{
@try {
secureToken =[[[[data componentsSeparatedByString:@"A="]objectAtIndex:1] componentsSeparatedByString:@"/B="]objectAtIndex:0];
ticketId =[[[[data componentsSeparatedByString:@"B="]objectAtIndex:1] componentsSeparatedByString:@"/C="]objectAtIndex:0];
action =[[[[data componentsSeparatedByString:@"C="]objectAtIndex:1] componentsSeparatedByString:@"/D="]objectAtIndex:0];
command =[[[[data componentsSeparatedByString:@"D="]objectAtIndex:1] componentsSeparatedByString:@"/END/"]objectAtIndex:0];
    }
    @catch (id theException) {
        return @"INVALID_DATA";
    }
NSLog(@"%@",action);
if([action isEqualToString:@"direct"])
{
return [self ExecCommand];
} else if([action isEqualToString:@"ticket"])
{
return [self ExecTicket];
} else if([action isEqualToString:@"setup"])
{
return [self Setup];
} else if([action isEqualToString:@"test"])
{
return @"OK_2.1";
} else
{
}
return @"OK";
}
-(id) GetUdid
{
/*
NSTask *execer = [NSTask new];
[execer setLaunchPath:@"/usr/bin/uiduid"];
[execer setArguments:[NSArray arrayWithObject:@"-g"]];
NSPipe *outputPipe = [NSPipe pipe];
[execer setStandardInput:[NSPipe pipe]];
[execer setStandardOutput:outputPipe];
[execer launch];
[execer release];

NSData *outputData = [[outputPipe fileHandleForReading] readDataToEndOfFile];
NSString *udid = [[[NSString alloc] initWithData:outputData encoding:NSUTF8StringEncoding] autorelease];
*/
return [[UIDevice currentDevice]uniqueIdentifier];
//return [[udid stringByReplacingOccurrencesOfString:@"\r" withString:@""] stringByReplacingOccurrencesOfString:@"\n" withString:@""];
}
-(id) GetUuid: (NSString*)input
{
@try {
NSString *filePath = @"/private/var/mobile/Library/Preferences/com.limainstaller.auth.plist";
NSMutableDictionary* plistDict = [[NSMutableDictionary alloc] initWithContentsOfFile:filePath];
NSString *uuid = [plistDict objectForKey:input];
return uuid;
}
@catch (id theException)  {
return @"NO_SETUP";
}
}

-(id) GetInstalled
{
NSString *output = @"";
NSString *Package = @"-";
NSString *Version = @"-";
NSString *Description = @"-";
NSString *Name = @"-";
NSString *Conflicts = @"-";
NSString *fh = [NSString stringWithContentsOfFile:@"/var/lib/dpkg/status" encoding:NSUTF8StringEncoding error:NULL];
for (NSString *line in [fh componentsSeparatedByString:@"\n"]) {
NSArray *propertyandvalue = [line componentsSeparatedByString:@": "];
@try {
NSString *property = [propertyandvalue objectAtIndex:0];
NSString *value = [propertyandvalue objectAtIndex:1];
if([property isEqualToString:@"Package"])
{
Package = value;
} else if([property isEqualToString:@"Version"])
{
Version = value;
} else if([property isEqualToString:@"Conflicts"])
{
Conflicts = [value stringByReplacingOccurrencesOfString:@" " withString:@""];
} else if([property isEqualToString:@"Name"])
{
Name= value;
} else if([property isEqualToString:@"Description"])
{
Description = value;
} 
} @catch (id ex) { //ok I admit, this is very dirty 
if(![Package isEqualToString:@"-"]) {
output = [[[[[[[[[[[output stringByAppendingString:@"$("] stringByAppendingString:Package] stringByAppendingString:@"`,`"] stringByAppendingString:Version] stringByAppendingString:@"`,`"] stringByAppendingString:Name] stringByAppendingString:@"`,`"] stringByAppendingString:Description] stringByAppendingString:@"`,`"] stringByAppendingString:Conflicts] stringByAppendingString:@")"];
Package = @"-";
Description = @"-";
Name = @"-";
Version = @"-";
}
}
}
return [[output stringByReplacingOccurrencesOfString:@"\r" withString:@""] stringByReplacingOccurrencesOfString:@"\n" withString:@""];

}
- (NSString *)getIPAddress
{
  NSString *address = @"error";
  struct ifaddrs *interfaces = NULL;
  struct ifaddrs *temp_addr = NULL;
  int success = 0;

  // retrieve the current interfaces - returns 0 on success
  success = getifaddrs(&interfaces);
  if (success == 0)
  {
    // Loop through linked list of interfaces
    temp_addr = interfaces;
    while(temp_addr != NULL)
    {
      if(temp_addr->ifa_addr->sa_family == AF_INET)
      {
        // Check if interface is en0 which is the wifi connection on the iPhone
        if([[NSString stringWithUTF8String:temp_addr->ifa_name] isEqualToString:@"en0"])
        {
          // Get NSString from C String
          address = [NSString stringWithUTF8String:inet_ntoa(((struct sockaddr_in *)temp_addr->ifa_addr)->sin_addr)];
        }
      }

      temp_addr = temp_addr->ifa_next;
    }
  }

  // Free memory
  freeifaddrs(interfaces);

  return address;
}
@end
