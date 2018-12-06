contract('Actionjoin', function(accounts) {
  it("should assert true", function(done) {
    var conference = Conference.at(Conference.deployed_address);
    assert.isTrue(true);
    done();   // stops tests at this point
  });
});